<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Diocese\{tdio_paroisse};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tdio_paroisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;

    

    public function index(Request $request)
    {
        $data = DB::table('tdio_paroisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        ->select("tdio_paroisse.id",'nom_paroisse','code_paroisse','description_paroisse',
        'autres_details_paroisse','refCatParoisse','tdio_paroisse.author','tdio_paroisse.refUser',
        'tdio_paroisse.active',"tdio_paroisse.created_at",

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_paroisse.nom_paroisse', 'like', '%'.$query.'%')
            ->orderBy("tdio_paroisse.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_paroisse_2()
    {
         $data = DB::table('tdio_paroisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        ->select("tdio_paroisse.id",'nom_paroisse','code_paroisse','description_paroisse',
        'autres_details_paroisse','refCatParoisse','tdio_paroisse.author','tdio_paroisse.refUser',
        'tdio_paroisse.active',"tdio_paroisse.created_at",

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //'id','nom_paroisse','code_paroisse','description_paroisse',
    // 'autres_details_paroisse','refCatParoisse','author','refUser','active'

    public function store(Request $request)
    {
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tdio_paroisse::where("id", $request->id)->update([
                'nom_paroisse'       =>  $request->nom_paroisse,
                'code_paroisse'    =>  $request->code_paroisse,
                'description_paroisse'    =>  $request->description_paroisse,
                'autres_details_paroisse'    =>  $request->autres_details_paroisse,
                'refCatParoisse'    =>  $request->refCatParoisse,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_paroisse::create([
                 'nom_paroisse'       =>  $request->nom_paroisse,
                'code_paroisse'    =>  $request->code_paroisse,
                'description_paroisse'    =>  $request->description_paroisse,
                'autres_details_paroisse'    =>  $request->autres_details_paroisse,
                'refCatParoisse'    =>  $request->refCatParoisse,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active  
            ]);

            //cmup
            return $this->msgJson('Insertion avec succès!!!');
        }
    }  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tdio_paroisse::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tdio_paroisse::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

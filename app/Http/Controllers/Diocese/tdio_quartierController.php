<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Diocese\{tdio_quartier};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdio_quartierController extends Controller
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
        $data = DB::table('tdio_quartier')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        ->select("tdio_quartier.id",'nom_quartier_dio','refParoisse','tdio_quartier.author',
        'tdio_quartier.refUser','tdio_quartier.active',"tdio_quartier.created_at",
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_quartier.nom_quartier_dio', 'like', '%'.$query.'%')
            ->orderBy("tdio_quartier.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_quartier_2()
    {
         $data = DB::table('tdio_quartier')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        ->select("tdio_quartier.id",'nom_quartier_dio','refParoisse','tdio_quartier.author',
        'tdio_quartier.refUser','tdio_quartier.active',"tdio_quartier.created_at",
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

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

    //'id','nom_quartier_dio','refParoisse','author','refUser','active'

    public function store(Request $request)
    {
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tdio_quartier::where("id", $request->id)->update([
                'nom_quartier_dio'       =>  $request->nom_quartier_dio,
                'refParoisse'    =>  $request->refParoisse,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_quartier::create([
                'nom_quartier_dio'       =>  $request->nom_quartier_dio,
                'refParoisse'    =>  $request->refParoisse,
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
        $data = tdio_quartier::where('id', $id)->get();
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
        $data = tdio_quartier::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

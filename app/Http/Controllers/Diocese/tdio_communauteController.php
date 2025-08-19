<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Diocese\{tdio_communaute};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tdio_communauteController extends Controller
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
        $data = DB::table('tdio_communaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_communaute.id",'nom_communaute','refQuartiers','tdio_communaute.author',
        'tdio_communaute.refUser','tdio_communaute.active',"tdio_communaute.created_at",

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_communaute.nom_communaute', 'like', '%'.$query.'%')
            ->orderBy("tdio_communaute.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_communaute_2()
    {
         $data = DB::table('tdio_communaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_communaute.id",'nom_communaute','refQuartiers','tdio_communaute.author',
        'tdio_communaute.refUser','tdio_communaute.active',"tdio_communaute.created_at",

        'nom_quartier_dio','refParoisse',
        
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

    //'id','nom_communaute','refQuartiers','author','refUser','active'

    public function store(Request $request)
    {
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tdio_communaute::where("id", $request->id)->update([
                'nom_communaute'       =>  $request->nom_communaute,
                'refQuartiers'    =>  $request->refQuartiers,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_communaute::create([
                'nom_communaute'       =>  $request->nom_communaute,
                'refQuartiers'    =>  $request->refQuartiers,
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
        $data = tdio_communaute::where('id', $id)->get();
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
        $data = tdio_communaute::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

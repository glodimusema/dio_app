<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Diocese\{tdio_carre};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// 'id','nom_carre','refCommunaute','author','refUser','active'


class tdio_carreController extends Controller
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
        $data = DB::table('tdio_carre')
        ->join('tdio_communaute','tdio_communaute.id','=','tdio_carre.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_carre.id",'nom_carre','refCommunaute','tdio_carre.author',
        'tdio_carre.refUser','tdio_carre.active',"tdio_carre.created_at",

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_carre.nom_carre', 'like', '%'.$query.'%')
            ->orderBy("tdio_carre.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_carre_2()
    {
         $data = DB::table('tdio_carre')
        ->join('tdio_communaute','tdio_communaute.id','=','tdio_carre.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_carre.id",'nom_carre','refCommunaute','tdio_carre.author',
        'tdio_carre.refUser','tdio_carre.active',"tdio_carre.created_at",

        'nom_communaute','refQuartiers',

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

    //'id','nom_carre','refCommunaute','author','refUser','active'

    public function store(Request $request)
    {
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tdio_carre::where("id", $request->id)->update([
                'nom_carre'       =>  $request->nom_carre,
                'refCommunaute'    =>  $request->refCommunaute,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_carre::create([
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

<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Diocese\{tdio_type_offrande};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


// 'id','nom_type_offrande','montant','author','refUser','active'



class tdio_type_offrandeController extends Controller
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
        //'id','nom_type_offrande','montant','author','refUser','active'
//tdio_type_offrande

        $data = DB::table("tdio_type_offrande")
        ->select("tdio_type_offrande.id", "tdio_type_offrande.nom_type_offrande",
        "tdio_type_offrande.montant",'tdio_type_offrande.author',
        'tdio_type_offrande.refUser','tdio_type_offrande.active', 
        "tdio_type_offrande.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_type_offrande.nom_type_offrande', 'like', '%'.$query.'%')
            ->orderBy("tdio_type_offrande.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_type_offrande_2()
    {
         $data = DB::table("tdio_type_offrande")
        ->select("tdio_type_offrande.id", "tdio_type_offrande.nom_type_offrande",
        "tdio_type_offrande.montant",'tdio_type_offrande.author',
        'tdio_type_offrande.refUser','tdio_type_offrande.active', 
        "tdio_type_offrande.created_at")
        ->get();
        return response()->json(['data' => $data]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update  
            $data = tdio_type_offrande::where("id", $request->id)->update([
                'nom_type_offrande' =>  $request->nom_type_offrande,
                'montant' =>  $request->montant,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_type_offrande::create([
                'nom_type_offrande' =>  $request->nom_type_offrande,
                'montant' =>  $request->montant,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);

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
        $data = tdio_type_offrande::where('id', $id)->get();
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
        $data = tdio_type_offrande::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_tranche};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



// tecole_tranche



class tecole_trancheController extends Controller
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
        $data = DB::table("tecole_tranche")
        ->select("tecole_tranche.id", "tecole_tranche.nom_tranche","tecole_tranche.code_tranche",
        'tecole_tranche.author','tecole_tranche.refUser','tecole_tranche.active', 
        "tecole_tranche.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_tranche.nom_tranche', 'like', '%'.$query.'%')
            ->orderBy("tecole_tranche.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_tranche_2()
    {
         $data = DB::table("tecole_tranche")
        ->select("tecole_tranche.id", "tecole_tranche.nom_tranche","tecole_tranche.code_tranche",
        'tecole_tranche.author','tecole_tranche.refUser','tecole_tranche.active', 
        "tecole_tranche.created_at")
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
            //'id','nom_tranche','code_tranche','author','refUser','active'
            # code...
            // update  
            $data = tecole_tranche::where("id", $request->id)->update([
                'nom_tranche' =>  $request->nom_tranche,
                'code_tranche' =>  $request->code_tranche,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_tranche::create([
                'nom_tranche' =>  $request->nom_tranche,
                'code_tranche' =>  $request->code_tranche,
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
        $data = tecole_tranche::where('id', $id)->get();
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
        $data = tecole_tranche::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

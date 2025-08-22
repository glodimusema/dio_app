<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_type_annee};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



class tecole_type_anneeController extends Controller
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

        $data = DB::table("tecole_type_annee")
        ->select("tecole_type_annee.id", "tecole_type_annee.nom_annee",
        "tecole_type_annee.code_annee",'tecole_type_annee.author','tecole_type_annee.refUser',
        'tecole_type_annee.active',"tecole_type_annee.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_type_annee.nom_annee', 'like', '%'.$query.'%')
            ->orderBy("tecole_type_annee.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_type_annee_2()
    {
         $data = DB::table("tecole_type_annee")
        ->select("tecole_type_annee.id", "tecole_type_annee.nom_annee","tecole_type_annee.code_annee",
        'tecole_type_annee.author','tecole_type_annee.refUser','tecole_type_annee.active', 
        "tecole_type_annee.created_at")
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
            //'id','nom_annee','code_annee','author','refUser','active'
            # code...
            // update  
            $data = tecole_type_annee::where("id", $request->id)->update([
                'nom_annee' =>  $request->nom_annee,
                'code_annee' =>  $request->code_annee,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_type_annee::create([
                'nom_annee' =>  $request->nom_annee,
                'code_annee' =>  $request->code_annee,
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
        $data = tecole_type_annee::where('id', $id)->get();
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
        $data = tecole_type_annee::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

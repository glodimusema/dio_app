<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_classe};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



// tecole_classe



class tecole_classeController extends Controller
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

        $data = DB::table("tecole_classe")
        ->select("tecole_classe.id", "tecole_classe.nom_classe","tecole_classe.code_classe",
        'tecole_classe.author','tecole_classe.refUser','tecole_classe.active', 
        "tecole_classe.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_classe.nom_classe', 'like', '%'.$query.'%')
            ->orderBy("tecole_classe.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_classe_2()
    {
         $data = DB::table("tecole_classe")
        ->select("tecole_classe.id", "tecole_classe.nom_classe","tecole_classe.code_classe",
        'tecole_classe.author','tecole_classe.refUser','tecole_classe.active', 
        "tecole_classe.created_at")
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
            //'id','nom_classe','code_classe','author','refUser','active'
            # code...
            // update  
            $data = tecole_classe::where("id", $request->id)->update([
                'nom_classe' =>  $request->nom_classe,
                'code_classe' =>  $request->code_classe,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_classe::create([
                'nom_classe' =>  $request->nom_classe,
                'code_classe' =>  $request->code_classe,
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
        $data = tecole_classe::where('id', $id)->get();
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
        $data = tecole_classe::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

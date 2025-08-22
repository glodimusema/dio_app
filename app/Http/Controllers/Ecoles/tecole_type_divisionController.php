<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_type_division};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



class tecole_type_divisionController extends Controller
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
        $data = DB::table("tecole_type_division")
        ->select("tecole_type_division.id", "tecole_type_division.nom_division",
        "tecole_type_division.code_division",'tecole_type_division.author',
        'tecole_type_division.refUser',
        'tecole_type_division.active',"tecole_type_division.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_type_division.nom_division', 'like', '%'.$query.'%')
            ->orderBy("tecole_type_division.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_type_division_2()
    {
         $data = DB::table("tecole_type_division")
        ->select("tecole_type_division.id", "tecole_type_division.nom_division","tecole_type_division.code_division",
        'tecole_type_division.author','tecole_type_division.refUser','tecole_type_division.active', 
        "tecole_type_division.created_at")
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
            //'id','nom_division','code_division','author','refUser','active'
            # code...
            // update  
            $data = tecole_type_division::where("id", $request->id)->update([
                'nom_division' =>  $request->nom_division,
                'code_division' =>  $request->code_division,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_type_division::create([
                'nom_division' =>  $request->nom_division,
                'code_division' =>  $request->code_division,
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
        $data = tecole_type_division::where('id', $id)->get();
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
        $data = tecole_type_division::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

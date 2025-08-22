<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_section};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



class tecole_sectionController extends Controller
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

        $data = DB::table("tecole_section")
        ->select("tecole_section.id", "tecole_section.nom_section",
        "tecole_section.code_section",'tecole_section.author','tecole_section.refUser',
        'tecole_section.active',"tecole_section.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_section.nom_section', 'like', '%'.$query.'%')
            ->orderBy("tecole_section.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_section_2()
    {
         $data = DB::table("tecole_section")
        ->select("tecole_section.id", "tecole_section.nom_section","tecole_section.code_section",
        'tecole_section.author','tecole_section.refUser','tecole_section.active', 
        "tecole_section.created_at")
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
            //'id','nom_section','code_section','author','refUser','active'
            # code...
            // update  
            $data = tecole_section::where("id", $request->id)->update([
                'nom_section' =>  $request->nom_section,
                'code_section' =>  $request->code_section,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_section::create([
                'nom_section' =>  $request->nom_section,
                'code_section' =>  $request->code_section,
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
        $data = tecole_section::where('id', $id)->get();
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
        $data = tecole_section::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Diocese\{tdio_type_sacrement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;




class tdio_type_sacrementController extends Controller
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
        //'id','nom_type_sacrement','code_type_sacrement','qualification_type_sacrement','author','refUser','active'

        $data = DB::table("tdio_type_sacrement")
        ->select("tdio_type_sacrement.id", "tdio_type_sacrement.nom_type_sacrement",
        "code_type_sacrement","qualification_type_sacrement","tdio_type_sacrement.active",
        'tdio_type_sacrement.author','tdio_type_sacrement.refUser',
        "tdio_type_sacrement.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_type_sacrement.nom_type_sacrement', 'like', '%'.$query.'%')
            ->orderBy("tdio_type_sacrement.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_type_sacrement_2()
    {
         $data = DB::table("tdio_type_sacrement")
        ->select("tdio_type_sacrement.id", "tdio_type_sacrement.nom_type_sacrement",
        "code_type_sacrement","qualification_type_sacrement","tdio_type_sacrement.active",
        'tdio_type_sacrement.author','tdio_type_sacrement.refUser',
        "tdio_type_sacrement.created_at")
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
            ////'id','nom_type_sacrement','code_type_sacrement','qualification_type_sacrement','author','refUser','active' 
            $data = tdio_type_sacrement::where("id", $request->id)->update([
                'nom_type_sacrement' =>  $request->nom_type_sacrement,
                'code_type_sacrement' =>  $request->code_type_sacrement,
                'qualification_type_sacrement' =>  $request->qualification_type_sacrement,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_type_sacrement::create([
                'nom_type_sacrement' =>  $request->nom_type_sacrement,
                'code_type_sacrement' =>  $request->code_type_sacrement,
                'qualification_type_sacrement' =>  $request->qualification_type_sacrement,
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
        $data = tdio_type_sacrement::where('id', $id)->get();
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
        $data = tdio_type_sacrement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Diocese\{tdio_categorie_paroisse};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;




class tdio_categorie_paroisseController extends Controller
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
        //id,nom_categorie_paroisse,author

        $data = DB::table("tdio_categorie_paroisse")
        ->select("tdio_categorie_paroisse.id", "tdio_categorie_paroisse.nom_categorie_paroisse",
        "code_categorie_paroisse","active",'author','refUser', "tdio_categorie_paroisse.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tdio_categorie_paroisse.nom_categorie_paroisse', 'like', '%'.$query.'%')
            ->orderBy("tdio_categorie_paroisse.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_categorie_paroisse_2()
    {
         $data = DB::table("tdio_categorie_paroisse")
        ->select("tdio_categorie_paroisse.id", "tdio_categorie_paroisse.nom_categorie_paroisse",
        "code_categorie_paroisse","active",'author','refUser', "tdio_categorie_paroisse.created_at")
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
            $data = tdio_categorie_paroisse::where("id", $request->id)->update([
                'nom_categorie_paroisse' =>  $request->nom_categorie_paroisse,
                'code_categorie_paroisse' =>  $request->code_categorie_paroisse,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_categorie_paroisse::create([
                'nom_categorie_paroisse' =>  $request->nom_categorie_paroisse,
                'code_categorie_paroisse' =>  $request->code_categorie_paroisse,
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
        $data = tdio_categorie_paroisse::where('id', $id)->get();
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
        $data = tdio_categorie_paroisse::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

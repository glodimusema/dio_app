<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ecoles\{tecole_ecoles};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;



// tecole_ecoles



class tecole_ecolesController extends Controller
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
        $data = DB::table("tecole_ecoles")
        ->select("tecole_ecoles.id",'nom_ecole','code_ecole','adresse_ecole','contact_ecole',
        'mail_ecole','autresdetails_ecole','tecole_ecoles.author','tecole_ecoles.refUser',
        'tecole_ecoles.active',"tecole_ecoles.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_ecoles.nom_ecole', 'like', '%'.$query.'%')
            ->orderBy("tecole_ecoles.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_ecoles_2()
    {
         $data = DB::table("tecole_ecoles")
        ->select("tecole_ecoles.id",'nom_ecole','code_ecole','adresse_ecole','contact_ecole',
        'mail_ecole','autresdetails_ecole','tecole_ecoles.author','tecole_ecoles.refUser',
        'tecole_ecoles.active',"tecole_ecoles.created_at")
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
            $data = tecole_ecoles::where("id", $request->id)->update([
                'nom_ecole' =>  $request->nom_ecole,
                'code_ecole' =>  $request->code_ecole,
                'adresse_ecole' =>  $request->adresse_ecole,
                'contact_ecole' =>  $request->contact_ecole,
                'mail_ecole' =>  $request->mail_ecole,
                'autresdetails_ecole' =>  $request->autresdetails_ecole,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_ecoles::create([
                'nom_ecole' =>  $request->nom_ecole,
                'code_ecole' =>  $request->code_ecole,
                'adresse_ecole' =>  $request->adresse_ecole,
                'contact_ecole' =>  $request->contact_ecole,
                'mail_ecole' =>  $request->mail_ecole,
                'autresdetails_ecole' =>  $request->autresdetails_ecole,
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
        $data = tecole_ecoles::where('id', $id)->get();
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
        $data = tecole_ecoles::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

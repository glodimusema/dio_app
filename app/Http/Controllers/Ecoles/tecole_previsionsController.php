<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ecoles\{tecole_previsions};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tecole_previsionsController extends Controller
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
        $data = DB::table('tecole_previsions')
            ->join('tecole_classe','tecole_classe.id','=','tecole_previsions.refClasse')
            ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_previsions.refAnnee')
            ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_previsions.refEcole')
            ->join('tecole_option','tecole_option.id','=','tecole_previsions.refOption')
            ->join('tecole_section','tecole_section.id','=','tecole_option.refSection') 

            ->select("tecole_previsions.id",'refClasse','refOption','refAnnee','refEcole',
            'montant_prevu','tecole_previsions.author','tecole_previsions.refUser',
            'tecole_previsions.active',"tecole_previsions.created_at",

            'nom_classe','code_classe',
            'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
            'nom_annee','code_annee',
            'nom_option','code_option','refSection',
            'nom_section','code_section'
        );

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_option.nom_option', 'like', '%'.$query.'%')
            ->orWhere('nom_classe', 'like', '%'.$query.'%')
            ->orWhere('nom_ecole', 'like', '%'.$query.'%')
            ->orWhere('nom_annee', 'like', '%'.$query.'%')
            ->orWhere('nom_section', 'like', '%'.$query.'%')
            ->orderBy("tecole_previsions.id", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_option_2()
    {
         $data = DB::table('tecole_previsions')
            ->join('tecole_classe','tecole_classe.id','=','tecole_previsions.refClasse')
            ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_previsions.refAnnee')
            ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_previsions.refEcole')
            ->join('tecole_option','tecole_option.id','=','tecole_previsions.refOption')
            ->join('tecole_section','tecole_section.id','=','tecole_option.refSection') 

            ->select("tecole_previsions.id",'refClasse','refOption','refAnnee','refEcole',
            'montant_prevu','tecole_previsions.author','tecole_previsions.refUser',
            'tecole_previsions.active',"tecole_previsions.created_at",

            'nom_classe','code_classe',
            'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
            'nom_annee','code_annee',
            'nom_option','code_option','refSection',
            'nom_section','code_section'
        )
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
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tecole_previsions::where("id", $request->id)->update([
                'refClasse'       =>  $request->refClasse,
                'refOption'    =>  $request->refOption,
                'refAnnee'    =>  $request->refAnnee,
                'refEcole'    =>  $request->refEcole,
                'montant_prevu'    =>  $request->montant_prevu,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_previsions::create([
                'refClasse'       =>  $request->refClasse,
                'refOption'    =>  $request->refOption,
                'refAnnee'    =>  $request->refAnnee,
                'refEcole'    =>  $request->refEcole,
                'montant_prevu'    =>  $request->montant_prevu,
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
        $data = tecole_previsions::where('id', $id)->get();
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
        $data = tecole_previsions::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

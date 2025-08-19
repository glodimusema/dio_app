<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Diocese\{tdio_responsable_paroisse};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

use App\User;
use App\Message;

class tdio_responsable_paroisseController extends Controller
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
        $data = DB::table('tdio_responsable_paroisse')
        ->join('tagent','tagent.id','=','tdio_responsable_paroisse.refResponsable')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_responsable_paroisse.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_responsable_paroisse.id",'refParoisse','refResponsable','autres_details_respo',
        'date_debut_responsable','dure_reponsable','date_fin_responsable','tdio_responsable_paroisse.author',
        'tdio_responsable_paroisse.refUser','tdio_responsable_paroisse.active',
        "tdio_responsable_paroisse.created_at",

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','tagent.slug',
        'tagent.cartes','tagent.envie',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tagent.noms_agent', 'like', '%'.$query.'%')
            ->orderBy("tdio_responsable_paroisse.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tdio_responsable_paroisse_2()
    {
         $data = DB::table('tdio_responsable_paroisse')
        ->join('tagent','tagent.id','=','tdio_responsable_paroisse.refResponsable')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_responsable_paroisse.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')  
        
        ->select("tdio_responsable_paroisse.id",'refParoisse','refResponsable','autres_details_respo',
        'date_debut_responsable','dure_reponsable','date_fin_responsable','tdio_responsable_paroisse.author',
        'tdio_responsable_paroisse.refUser','tdio_responsable_paroisse.active',
        "tdio_responsable_paroisse.created_at",

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','tagent.slug',
        'tagent.cartes','tagent.envie',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //'id','refParoisse','refResponsable','autres_details_respo',
    // 'date_debut_responsable','dure_reponsable','date_fin_responsable','author',
    // 'refUser','active'

    public function store(Request $request)
    {
        $currentDate = Carbon::parse($request->date_debut_responsable);
        $duree = (int)$request->dure_reponsable;
        $newDate = $currentDate->addMonths($duree);

        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tdio_responsable_paroisse::where("id", $request->id)->update([
                'refParoisse'       =>  $request->refParoisse,
                'refResponsable'    =>  $request->refResponsable,
                'autres_details_respo'    =>  $request->autres_details_respo,
                'date_debut_responsable'    =>  $request->date_debut_responsable,
                'dure_reponsable'    =>  $request->dure_reponsable,
                'date_fin_responsable'    =>  $newDate,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdio_responsable_paroisse::create([
                'refParoisse'       =>  $request->refParoisse,
                'refResponsable'    =>  $request->refResponsable,
                'autres_details_respo'    =>  $request->autres_details_respo,
                'date_debut_responsable'    =>  $request->date_debut_responsable,
                'dure_reponsable'    =>  $request->dure_reponsable,
                'date_fin_responsable'    =>  $newDate,
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
        $data = tdio_responsable_paroisse::where('id', $id)->get();
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
        $data = tdio_responsable_paroisse::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

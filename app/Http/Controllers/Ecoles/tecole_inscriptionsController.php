<?php

namespace App\Http\Controllers\Ecoles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ecoles\tecole_inscriptions;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tecole_inscriptionsController extends Controller
{
    use GlobalMethod, Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }  

    // 'id','refEleve','refClasse','refOption','refDivision','refAnnee'
    // ,'refEcole','montant_prevu','montant_paie','autres_details_inscription','author','refUser','active'



    public function all(Request $request)
    { 

        $data = DB::table('tecole_inscriptions')
        ->join('tecole_classe','tecole_classe.id','=','tecole_inscriptions.refClasse')
        ->join('tecole_option','tecole_option.id','=','tecole_inscriptions.refOption')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')
        ->join('tecole_type_division','tecole_type_division.id','=','tecole_inscriptions.refDivision')
        ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_inscriptions.refAnnee')
        ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_inscriptions.refEcole')
        
        ->join('tecole_eleves','tecole_eleves.id','=','tecole_inscriptions.refEleve')
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
      
        ->select('tecole_inscriptions.id','refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        'tecole_inscriptions.author','tecole_inscriptions.refUser','tecole_inscriptions.active',
        "tecole_inscriptions.created_at",

        'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',"avenues.nomAvenue", 
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille","communes.nomCommune","villes.idProvince","villes.nomVille",
        "provinces.idPays","provinces.nomProvince","pays.nomPays","cartes","envie",

        'nom_classe','code_classe',
        'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
        'nom_annee','code_annee',
        'nom_option','code_option','refSection',
        'nom_section','code_section',
        'nom_division','code_division')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_eleve', 'like', '%'.$query.'%')               
            ->orWhere('nom_classe', 'like', '%'.$query.'%')
            ->orWhere('nom_annee', 'like', '%'.$query.'%')
            ->orWhere('nom_option', 'like', '%'.$query.'%')    
            ->orWhere('nom_section', 'like', '%'.$query.'%')      
            ->orderBy("tecole_inscriptions.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tecole_inscriptions.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tecole_inscriptions')
        ->join('tecole_classe','tecole_classe.id','=','tecole_inscriptions.refClasse')
        ->join('tecole_option','tecole_option.id','=','tecole_inscriptions.refOption')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')
        ->join('tecole_type_division','tecole_type_division.id','=','tecole_inscriptions.refDivision')
        ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_inscriptions.refAnnee')
        ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_inscriptions.refEcole')
        
        ->join('tecole_eleves','tecole_eleves.id','=','tecole_inscriptions.refEleve')
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
      
        ->select('tecole_inscriptions.id','refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        'tecole_inscriptions.author','tecole_inscriptions.refUser','tecole_inscriptions.active',
        "tecole_inscriptions.created_at",

        'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',"avenues.nomAvenue", 
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille","communes.nomCommune","villes.idProvince","villes.nomVille",
        "provinces.idPays","provinces.nomProvince","pays.nomPays","cartes","envie",

        'nom_classe','code_classe',
        'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
        'nom_annee','code_annee',
        'nom_option','code_option','refSection',
        'nom_section','code_section',
        'nom_division','code_division')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
        ->Where('tecole_inscriptions.refEleve',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_eleve', 'like', '%'.$query.'%')               
            ->orWhere('nom_classe', 'like', '%'.$query.'%')
            ->orWhere('nom_annee', 'like', '%'.$query.'%')
            ->orWhere('nom_option', 'like', '%'.$query.'%')    
            ->orWhere('nom_section', 'like', '%'.$query.'%')          
            ->orderBy("tecole_inscriptions.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tecole_inscriptions.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tecole_inscriptions')
        ->join('tecole_classe','tecole_classe.id','=','tecole_inscriptions.refClasse')
        ->join('tecole_option','tecole_option.id','=','tecole_inscriptions.refOption')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')
        ->join('tecole_type_division','tecole_type_division.id','=','tecole_inscriptions.refDivision')
        ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_inscriptions.refAnnee')
        ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_inscriptions.refEcole')
        
        ->join('tecole_eleves','tecole_eleves.id','=','tecole_inscriptions.refEleve')
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
      
        ->select('tecole_inscriptions.id','refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        'tecole_inscriptions.author','tecole_inscriptions.refUser','tecole_inscriptions.active',
        "tecole_inscriptions.created_at",

        'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',"avenues.nomAvenue", 
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille","communes.nomCommune","villes.idProvince","villes.nomVille",
        "provinces.idPays","provinces.nomProvince","pays.nomPays","cartes","envie",

        'nom_classe','code_classe',
        'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
        'nom_annee','code_annee',
        'nom_option','code_option','refSection',
        'nom_section','code_section',
        'nom_division','code_division')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
        ->where('tecole_inscriptions.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tecole_inscriptions')
        ->join('tecole_classe','tecole_classe.id','=','tecole_inscriptions.refClasse')
        ->join('tecole_option','tecole_option.id','=','tecole_inscriptions.refOption')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')
        ->join('tecole_type_division','tecole_type_division.id','=','tecole_inscriptions.refDivision')
        ->join('tecole_type_annee','tecole_type_annee.id','=','tecole_inscriptions.refAnnee')
        ->join('tecole_ecoles','tecole_ecoles.id','=','tecole_inscriptions.refEcole')
        
        ->join('tecole_eleves','tecole_eleves.id','=','tecole_inscriptions.refEleve')
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
      
        ->select('tecole_inscriptions.id','refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        'tecole_inscriptions.author','tecole_inscriptions.refUser','tecole_inscriptions.active',
        "tecole_inscriptions.created_at",

        'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',"avenues.nomAvenue", 
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille","communes.nomCommune","villes.idProvince","villes.nomVille",
        "provinces.idPays","provinces.nomProvince","pays.nomPays","cartes","envie",

        'nom_classe','code_classe',
        'nom_ecole','code_ecole','adresse_ecole','contact_ecole','mail_ecole','autresdetails_ecole',
        'nom_annee','code_annee',
        'nom_option','code_option','refSection',
        'nom_section','code_section',
        'nom_division','code_division')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')     
       ->Where('tecole_inscriptions.refEleve',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $montants = 0;

        $data5 =  DB::table("tecole_previsions")
        ->select('id','refClasse','refOption','refAnnee','refEcole',
        'montant_prevu','author','refUser','active')
        ->where([
            ['refClasse','=', $request->refClasse],
            ['refOption','=', $request->refOption],
            ['refAnnee','=', $request->refAnnee],
            ['refEcole','=', $request->refEcole]
        ]) 
        ->first(); 
        if ($data5) 
        {                                
           $montants=$data5->montant_prevu;                           
        }

        
        $data = tecole_inscriptions::create([
            'refEleve'       =>  $request->refEleve,
            'refClasse'    =>  $request->refClasse,
            'refOption'    =>  $request->refOption,
            'refDivision'    =>  $request->refDivision,
            'refAnnee'    =>  $request->refAnnee,  
            'refEcole'    =>  $request->refEcole,
            'montant_prevu'    =>  $montants,
            'montant_paie'    =>  0,  
            'autres_details_inscription'    =>  $request->autres_details_inscription,              
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,
            'active'    =>  $active
        ]);     
        
    
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $current = Carbon::now();
        $active = "OUI";  
        $montants = 0;

        $data5 =  DB::table("tecole_previsions")
        ->select('id','refClasse','refOption','refAnnee','refEcole',
        'montant_prevu','author','refUser','active')
        ->where([
            ['refClasse','=', $request->refClasse],
            ['refOption','=', $request->refOption],
            ['refAnnee','=', $request->refAnnee],
            ['refEcole','=', $request->refEcole]
        ]) 
        ->first(); 
        if ($data5) 
        {                                
           $montants=$data5->montant_prevu;                           
        }     

        $data = tecole_inscriptions::where('id', $id)->update([
            'refEleve'       =>  $request->refEleve,
            'refClasse'    =>  $request->refClasse,
            'refOption'    =>  $request->refOption,
            'refDivision'    =>  $request->refDivision,
            'refAnnee'    =>  $request->refAnnee,  
            'refEcole'    =>  $request->refEcole,
            'montant_prevu'    =>  $montants,
            'autres_details_inscription'    =>  $request->autres_details_inscription,              
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,
            'active'    =>  $active
        ]);
      

        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {

        $data = tecole_inscriptions::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 7;
        $active = "OUI";

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $montants = 0;

            $data5 =  DB::table("tecole_previsions")
            ->select('id','refClasse','refOption','refAnnee','refEcole',
            'montant_prevu','author','refUser','active')
            ->where([
                ['refClasse','=', $request->refClasse],
                ['refOption','=', $request->refOption],
                ['refAnnee','=', $request->refAnnee],
                ['refEcole','=', $request->refEcole]
            ]) 
            ->first(); 
            if ($data5) 
            {                                
                $montants=$data5->montant_prevu;                           
            }

            $active = "OUI";

            $data = tecole_inscriptions::create([

                'refEleve'       =>  $data['refEleve'],
                'refClasse'    =>  $request->refClasse,
                'refOption'    =>  $request->refOption,
                'refDivision'    =>  $request->refDivision,
                'refAnnee'    =>  $request->refAnnee,  
                'refEcole'    =>  $request->refEcole,
                'montant_prevu'    =>  $montants,
                'montant_paie'    =>  0,  
                'autres_details_inscription'    =>  $request->autres_details_inscription,              
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $active
            ]);         

    
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }




}

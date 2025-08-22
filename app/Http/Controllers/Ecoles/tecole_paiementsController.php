<?php

namespace App\Http\Controllers\Ecoles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ecoles\tecole_paiements;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tecole_paiementsController extends Controller
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

    // 'id','RefInscription','refBanque','montant_paie','devise',
    // 'taux','date_paie','modepaie','libellepaie','numeroBordereau','author','refUser',
    // 'active'

    
    public function all(Request $request)
    { 
 
        $data = DB::table('tecole_paiements')
        ->join('tecole_inscriptions','tecole_inscriptions.id','=','tecole_paiements.RefInscription')
        
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

        ->join('tconf_banque' , 'tconf_banque.id','=','tecole_paiements.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tecole_paiements.id','RefInscription','refBanque','montant_paie','devise',
        'taux','date_paie','modepaie','libellepaie','numeroBordereau','tecole_paiements.author',
        'tecole_paiements.refUser','tecole_paiements.active','tecole_paiements.created_at'
            

        ,'refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        
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
        'nom_division','code_division',

        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')

        ->selectRaw('((montant_paie)/tecole_paiements.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tecole_paiements.id) as codeRecu');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_eleve', 'like', '%'.$query.'%')          
            ->orderBy("tecole_paiements.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tecole_paiements.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tecole_paiements')
        ->join('tecole_inscriptions','tecole_inscriptions.id','=','tecole_paiements.RefInscription')
        
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

        ->join('tconf_banque' , 'tconf_banque.id','=','tecole_paiements.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tecole_paiements.id','RefInscription','refBanque','montant_paie','devise',
        'taux','date_paie','modepaie','libellepaie','numeroBordereau','tecole_paiements.author',
        'tecole_paiements.refUser','tecole_paiements.active','tecole_paiements.created_at'
            

        ,'refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        
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
        'nom_division','code_division',

        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')

        ->selectRaw('((montant_paie)/tecole_paiements.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tecole_paiements.id) as codeRecu')
        ->Where('tecole_paiements.RefInscription',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_eleve', 'like', '%'.$query.'%')          
            ->orderBy("tecole_paiements.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tecole_paiements.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  
    
    


   



    function fetch_single_data($id)
    {
        $data= DB::table('tecole_paiements')
        ->join('tecole_inscriptions','tecole_inscriptions.id','=','tecole_paiements.RefInscription')
        
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

        ->join('tconf_banque' , 'tconf_banque.id','=','tecole_paiements.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tecole_paiements.id','RefInscription','refBanque','montant_paie','devise',
        'taux','date_paie','modepaie','libellepaie','numeroBordereau','tecole_paiements.author',
        'tecole_paiements.refUser','tecole_paiements.active','tecole_paiements.created_at'
            

        ,'refEleve','refClasse','refOption','refDivision',
        'refAnnee','refEcole','montant_prevu','montant_paie','autres_details_inscription',
        
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
        'nom_division','code_division',

        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')

        ->selectRaw('((montant_paie)/tecole_paiements.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tecole_paiements.id) as codeRecu')
        ->where('tecole_paiements.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'id','code','date_entete_paie','refService','module_id','author','refUser'
    function insert_data(Request $request)
    {
        $current = Carbon::now(); 

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
       
        $data = tecole_paiements::create([
            'RefInscription'       =>  $request->RefInscription,
            'refBanque'       =>  $request->refBanque,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'active'       =>  $active
        ]);

        $data3 = DB::update(
            'update tecole_inscriptions set montant_paie = montant_paie + (:paiement) where id = :refInscription',
            ['paiement' => $montants,'refInscription' =>  $request->RefInscription]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

       }



    }



    function update_data(Request $request, $id)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }


        $data = tecole_paiements::where('id', $id)->update([
            'RefInscription'       =>  $request->RefInscription,
            'refBanque'       =>  $request->refBanque,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'active'       =>  $active
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }
    }

    function delete_data($id)
    {
        $idInscription=0;
        $montants=0;

        $deleteds = DB::table('tecole_paiements')->Where('id',$id)->first(); 
        if ($deleteds) {
            $idInscription = $deleteds->RefInscription;
            $montants = $deleteds->montant_paie;
        }
        $data3 = DB::update(
            'update tecole_inscriptions set montant_paie = montant_paie - (:paiement) where id = :refInscription',
            ['paiement' => $montants,'refInscription' =>  $idInscription]
        );

        $data = tecole_paiements::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}

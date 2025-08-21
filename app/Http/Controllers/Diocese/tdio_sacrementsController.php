<?php

namespace App\Http\Controllers\Diocese;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Diocese\tdio_sacrements;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tdio_sacrementsController extends Controller
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

    public function all(Request $request)
    { 

        $data = DB::table('tdio_sacrements')
        ->join('tdio_type_sacrement','tdio_type_sacrement.id','=','tdio_sacrements.refTypeSacrement')
        ->join('tdio_chretien','tdio_chretien.id','=','tdio_sacrements.refChretien')
        
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')

        ->select('tdio_sacrements.id','refChretien','refTypeSacrement','refCommunaute',
        'refPretre','refCure','date_sacrement','temoin1','temoin2','autres_details_offrende',
        'refConjoint','tdio_sacrements.author','tdio_sacrements.refUser','tdio_sacrements.active',
        "tdio_sacrements.created_at",

        'noms_chretien','adresse_chretien','contact1_chretien','contact2_chretien','mail_chretien',
        'nom_pere_chretien','nom_mere_chretien','lieunaissance_chretien','datenaissance_chretien',
        'photo','refCommunaute','date_sacrement','statut_sacrement',

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse",

        "tdio_type_sacrement.nom_type_sacrement","code_type_sacrement",
        "qualification_type_sacrement")

        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_chretien', 'like', '%'.$query.'%')               
            ->orWhere('nom_communaute', 'like', '%'.$query.'%')
            ->orWhere('nom_quartier_dio', 'like', '%'.$query.'%')
            ->orWhere('nom_paroisse', 'like', '%'.$query.'%')    
            ->orWhere('nom_type_sacrement', 'like', '%'.$query.'%')      
            ->orderBy("tdio_sacrements.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tdio_sacrements.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tdio_sacrements')
        ->join('tdio_type_sacrement','tdio_type_sacrement.id','=','tdio_sacrements.refTypeSacrement')
        ->join('tdio_chretien','tdio_chretien.id','=','tdio_sacrements.refChretien')
        
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')

        ->select('tdio_sacrements.id','refChretien','refTypeSacrement','refCommunaute',
        'refPretre','refCure','date_sacrement','temoin1','temoin2','autres_details_offrende',
        'refConjoint','tdio_sacrements.author','tdio_sacrements.refUser','tdio_sacrements.active',
        "tdio_sacrements.created_at",

        'noms_chretien','adresse_chretien','contact1_chretien','contact2_chretien','mail_chretien',
        'nom_pere_chretien','nom_mere_chretien','lieunaissance_chretien','datenaissance_chretien',
        'photo','refCommunaute','date_sacrement','statut_sacrement',

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse",

        "tdio_type_sacrement.nom_type_sacrement","code_type_sacrement",
        "qualification_type_sacrement")

        ->Where('tdio_sacrements.refChretien',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_type_sacrement', 'like', '%'.$query.'%')
            ->orWhere('nom_communaute', 'like', '%'.$query.'%')
            ->orWhere('nom_quartier_dio', 'like', '%'.$query.'%')
            ->orWhere('nom_paroisse', 'like', '%'.$query.'%')           
            ->orderBy("tdio_sacrements.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tdio_sacrements.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tdio_sacrements')
        ->join('tdio_type_sacrement','tdio_type_sacrement.id','=','tdio_sacrements.refTypeSacrement')
        ->join('tdio_chretien','tdio_chretien.id','=','tdio_sacrements.refChretien')
        
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')

        ->select('tdio_sacrements.id','refChretien','refTypeSacrement','refCommunaute',
        'refPretre','refCure','date_sacrement','temoin1','temoin2','autres_details_offrende',
        'refConjoint','tdio_sacrements.author','tdio_sacrements.refUser','tdio_sacrements.active',
        "tdio_sacrements.created_at",

        'noms_chretien','adresse_chretien','contact1_chretien','contact2_chretien','mail_chretien',
        'nom_pere_chretien','nom_mere_chretien','lieunaissance_chretien','datenaissance_chretien',
        'photo','refCommunaute','date_sacrement','statut_sacrement',

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse",

        "tdio_type_sacrement.nom_type_sacrement","code_type_sacrement",
        "qualification_type_sacrement")

        ->where('tdio_sacrements.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tdio_sacrements')
        ->join('tdio_type_sacrement','tdio_type_sacrement.id','=','tdio_sacrements.refTypeSacrement')
        ->join('tdio_chretien','tdio_chretien.id','=','tdio_sacrements.refChretien')
        
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')

        ->select('tdio_sacrements.id','refChretien','refTypeSacrement','refCommunaute',
        'refPretre','refCure','date_sacrement','temoin1','temoin2','autres_details_offrende',
        'refConjoint','tdio_sacrements.author','tdio_sacrements.refUser','tdio_sacrements.active',
        "tdio_sacrements.created_at",

        'noms_chretien','adresse_chretien','contact1_chretien','contact2_chretien','mail_chretien',
        'nom_pere_chretien','nom_mere_chretien','lieunaissance_chretien','datenaissance_chretien',
        'photo','refCommunaute','date_sacrement','statut_sacrement',

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse",

        "tdio_type_sacrement.nom_type_sacrement","code_type_sacrement",
        "qualification_type_sacrement")
     
       ->Where('tdio_sacrements.refChretien',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";
        
        $refCommunaute = 0;
        $data5 =  DB::table("tdio_chretien")
        ->select('id','noms_chretien','adresse_chretien','contact1_chretien',
        'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
        'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute',
        'date_sacrement','statut_sacrement','author','refUser','active')
        ->Where('tdio_chretien.id', $request->refChretien)
        ->first(); 
        if ($data5) 
        {                                
            $refCommunaute = $data5->refCommunaute;                           
        }

        $data = tdio_sacrements::create([
            'refChretien'       =>  $request->refChretien,
            'refTypeSacrement'    =>  $request->refTypeSacrement,
            'refCommunaute'    =>  $refCommunaute,
            'refPretre'    =>  $request->refPretre,
            'refCure'    =>  $request->refCure, 
            'date_sacrement'    =>  $request->date_sacrement,
            'temoin1'    =>  $request->temoin1,
            'temoin2'    =>  $request->temoin2,
            'autres_details_offrende'    =>  $request->autres_details_offrende,
            'refConjoint'    =>  $request->refConjoint,
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

        $refCommunaute = 0;
        $data5 =  DB::table("tdio_chretien")
        ->select('id','noms_chretien','adresse_chretien','contact1_chretien',
        'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
        'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute',
        'date_sacrement','statut_sacrement','author','refUser','active')
        ->Where('tdio_chretien.id', $request->refChretien)
        ->first(); 
        if ($data5) 
        {                                
            $refCommunaute = $data5->refCommunaute;                           
        }

        $data = tdio_sacrements::where('id', $id)->update([
            'refChretien'       =>  $request->refChretien,
            'refTypeSacrement'    =>  $request->refTypeSacrement,
            'refCommunaute'    =>  $refCommunaute,
            'refPretre'    =>  $request->refPretre,
            'refCure'    =>  $request->refCure, 
            'date_sacrement'    =>  $request->date_sacrement,
            'temoin1'    =>  $request->temoin1,
            'temoin2'    =>  $request->temoin2,
            'autres_details_offrende'    =>  $request->autres_details_offrende,
            'refConjoint'    =>  $request->refConjoint,
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

        $data = tdio_sacrements::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $active = "OUI";

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $refCommunaute = 0;
            $data5 =  DB::table("tdio_chretien")
            ->select('id','noms_chretien','adresse_chretien','contact1_chretien',
            'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
            'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute',
            'date_sacrement','statut_sacrement','author','refUser','active')
            ->Where('tdio_chretien.id', $data['refChretien'])
            ->first(); 
            if ($data5) 
            {                                
                $refCommunaute = $data5->refCommunaute;                           
            }

           $data = tdio_sacrements::where('id', $id)->update([
                'refChretien'       =>  $data['refChretien'],
                'refTypeSacrement'    =>  $data['refTypeSacrement'],
                'refCommunaute'    =>  $refCommunaute,
                'refPretre'    =>  $request->refPretre,
                'refCure'    =>  $request->refCure, 
                'date_sacrement'    =>  $request->date_sacrement,
                'temoin1'    =>  $data['temoin1'],
                'temoin2'    =>  $data['temoin2'],
                'autres_details_offrende'    =>  $request->autres_details_offrende,
                'refConjoint'    =>  $data['refConjoint'],
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

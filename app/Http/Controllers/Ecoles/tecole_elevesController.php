<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ecoles\{tecole_eleves};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tecole_elevesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }


    public function index(Request $request)
    { 
        if (!is_null($request->get('query'))) {
                # code...
            $query = $this->Gquery($request);

            $data = DB::table('tecole_eleves')            
            ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tecole_eleves.id",'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
            'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
            'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
            'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
            'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
            'tecole_eleves.deleted','tecole_eleves.author_deleted',
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tecole_eleves.author","tecole_eleves.created_at","tecole_eleves.updated_at","cartes","envie")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
            ->where('noms_eleve', 'like', '%'.$query.'%')               
            ->orWhere('nomAvenue', 'like', '%'.$query.'%')
            ->orWhere('nomQuartier', 'like', '%'.$query.'%')
            ->orWhere('nomCommune', 'like', '%'.$query.'%')
            ->orWhere('nomProvince', 'like', '%'.$query.'%')
            ->orderBy("tecole_eleves.noms_eleve", "asc")
            ->paginate(80);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tecole_eleves')            
            ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tecole_eleves.id",'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
            'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
            'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
            'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
            'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
            'tecole_eleves.deleted','tecole_eleves.author_deleted',
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tecole_eleves.author","tecole_eleves.created_at","tecole_eleves.updated_at","cartes","envie")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
            ->orderBy("tecole_eleves.noms_eleve", "asc")
            ->paginate(80);

             return response($data, 200);
            }

        }
    
    public function Profiletecole_eleves($id, Request $request)
    {
        //
        $data = DB::table('tecole_eleves')            
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //
        ->select("tecole_eleves.id",'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tecole_eleves.author","tecole_eleves.created_at","tecole_eleves.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
        ->where([
            ['tecole_eleves.id', $id]
        ])->get();

        return response()->json(['data'  =>  $data]);
        
    }


    function fetch_list_eleve()
    {
        $data = DB::table('tecole_eleves')            
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //
        ->select("tecole_eleves.id",'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tecole_eleves.author","tecole_eleves.created_at","tecole_eleves.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
        ->orderBy("noms_eleve", "asc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }




    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms_eleve.''.$formData->noms_eleve,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);            
            //nummaison_eleve
            tecole_eleves::create([
                'matricule_eleve'  =>  $formData->matricule_eleve,
                'noms_eleve'    =>  $formData->noms_eleve,
                'sexe_eleve'         =>  $formData->sexe_eleve,                
                'datenaissance_eleve'      =>  $formData->datenaissance_eleve,                
                'lieunaissnce_eleve'  =>  $formData->lieunaissnce_eleve, 
                'provinceOrigine_eleve'  =>  $formData->provinceOrigine_eleve,
                'etatcivil_eleve'  =>  $formData->etatcivil_eleve,
                'refAvenue_eleve'  =>  $formData->refAvenue_eleve,
                'nummaison_eleve'  =>  $formData->nummaison_eleve,
                'contact1_eleve'  =>  $formData->contact1_eleve,
                'contact2_eleve'  =>  $formData->contact2_eleve,
                'mail_eleve'  =>  $formData->mail_eleve,
                'nomPere_eleve'  =>  $formData->nomPere_eleve,
                'nomMere_eleve'  =>  $formData->nomMere_eleve,
                'Nationalite_eleve'  =>  $formData->Nationalite_eleve,
                'Collectivite_eleve'  =>  $formData->Collectivite_eleve,
                'Territoire_eleve'  =>  $formData->Territoire_eleve,
                'EmployeurAnt_eleve'  =>  $formData->EmployeurAnt_eleve,
                'PersRef_eleve'  =>  $formData->PersRef_eleve, 
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'          =>  'OUI'       
            ]);
            return $this->msgJson('Information ajoutée avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->noms_eleve.''.$formData->noms_eleve,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            tecole_eleves::create([
                'matricule_eleve'  =>  $formData->matricule_eleve,
                'noms_eleve'    =>  $formData->noms_eleve,
                'sexe_eleve'         =>  $formData->sexe_eleve,                
                'datenaissance_eleve'      =>  $formData->datenaissance_eleve,                
                'lieunaissnce_eleve'  =>  $formData->lieunaissnce_eleve, 
                'provinceOrigine_eleve'  =>  $formData->provinceOrigine_eleve,
                'etatcivil_eleve'  =>  $formData->etatcivil_eleve,
                'refAvenue_eleve'  =>  $formData->refAvenue_eleve,
                'nummaison_eleve'  =>  $formData->nummaison_eleve,
                'contact1_eleve'  =>  $formData->contact1_eleve,
                'contact2_eleve'  =>  $formData->contact2_eleve,
                'mail_eleve'  =>  $formData->mail_eleve,
                'nomPere_eleve'  =>  $formData->nomPere_eleve,
                'nomMere_eleve'  =>  $formData->nomMere_eleve,
                'Nationalite_eleve'  =>  $formData->Nationalite_eleve,
                'Collectivite_eleve'  =>  $formData->Collectivite_eleve,
                'Territoire_eleve'  =>  $formData->Territoire_eleve,
                'EmployeurAnt_eleve'  =>  $formData->EmployeurAnt_eleve,
                'PersRef_eleve'  =>  $formData->PersRef_eleve, 
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'          =>  'OUI' 
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms_eleve.''.$formData->noms_eleve,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tecole_eleves::where('id',$formData->id)->update([
                'matricule_eleve'  =>  $formData->matricule_eleve,
                'noms_eleve'    =>  $formData->noms_eleve,
                'sexe_eleve'         =>  $formData->sexe_eleve,                
                'datenaissance_eleve'      =>  $formData->datenaissance_eleve,                
                'lieunaissnce_eleve'  =>  $formData->lieunaissnce_eleve, 
                'provinceOrigine_eleve'  =>  $formData->provinceOrigine_eleve,
                'etatcivil_eleve'  =>  $formData->etatcivil_eleve,
                'refAvenue_eleve'  =>  $formData->refAvenue_eleve,
                'nummaison_eleve'  =>  $formData->nummaison_eleve,
                'contact1_eleve'  =>  $formData->contact1_eleve,
                'contact2_eleve'  =>  $formData->contact2_eleve,
                'mail_eleve'  =>  $formData->mail_eleve,
                'nomPere_eleve'  =>  $formData->nomPere_eleve,
                'nomMere_eleve'  =>  $formData->nomMere_eleve,
                'Nationalite_eleve'  =>  $formData->Nationalite_eleve,
                'Collectivite_eleve'  =>  $formData->Collectivite_eleve,
                'Territoire_eleve'  =>  $formData->Territoire_eleve,
                'EmployeurAnt_eleve'  =>  $formData->EmployeurAnt_eleve,
                'PersRef_eleve'  =>  $formData->PersRef_eleve, 
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'          =>  'OUI'
            ]);
            return $this->msgJson('Modifcation avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->noms_eleve.''.$formData->noms_eleve,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tecole_eleves::where('id',$formData->id)->update([
                'matricule_eleve'  =>  $formData->matricule_eleve,
                'noms_eleve'    =>  $formData->noms_eleve,
                'sexe_eleve'         =>  $formData->sexe_eleve,                
                'datenaissance_eleve'      =>  $formData->datenaissance_eleve,                
                'lieunaissnce_eleve'  =>  $formData->lieunaissnce_eleve, 
                'provinceOrigine_eleve'  =>  $formData->provinceOrigine_eleve,
                'etatcivil_eleve'  =>  $formData->etatcivil_eleve,
                'refAvenue_eleve'  =>  $formData->refAvenue_eleve,
                'nummaison_eleve'  =>  $formData->nummaison_eleve,
                'contact1_eleve'  =>  $formData->contact1_eleve,
                'contact2_eleve'  =>  $formData->contact2_eleve,
                'mail_eleve'  =>  $formData->mail_eleve,
                'nomPere_eleve'  =>  $formData->nomPere_eleve,
                'nomMere_eleve'  =>  $formData->nomMere_eleve,
                'Nationalite_eleve'  =>  $formData->Nationalite_eleve,
                'Collectivite_eleve'  =>  $formData->Collectivite_eleve,
                'Territoire_eleve'  =>  $formData->Territoire_eleve,
                'EmployeurAnt_eleve'  =>  $formData->EmployeurAnt_eleve,
                'PersRef_eleve'  =>  $formData->PersRef_eleve, 
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'          =>  'OUI'
            ]);
            return $this->msgJson('Modifcation avec succès');

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
        $data = DB::table('tecole_eleves')            
        ->join('avenues' , 'avenues.id','=','tecole_eleves.refAvenue_eleve')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //
        ->select("tecole_eleves.id",'matricule_eleve','noms_eleve','sexe_eleve','datenaissance_eleve',
        'lieunaissnce_eleve','provinceOrigine_eleve','etatcivil_eleve','refAvenue_eleve','nummaison_eleve',
        'contact1_eleve','contact2_eleve','mail_eleve','nomPere_eleve','nomMere_eleve','Nationalite_eleve',
        'Collectivite_eleve','Territoire_eleve','EmployeurAnt_eleve','PersRef_eleve','photo','slug','cartes',
        'envie','tecole_eleves.author','tecole_eleves.refUser','tecole_eleves.active',
        'tecole_eleves.deleted','tecole_eleves.author_deleted',
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tecole_eleves.author","tecole_eleves.created_at","tecole_eleves.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_eleve, CURDATE()) as age_eleve')
        ->where('tecole_eleves.id', $id)->get();

        
        return response()->json(['data'  =>  $data]);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $connected)
    {
        //
        $data = tecole_eleves::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tecole_eleves::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreDatatecole_eleves($id, $connected)
    {
        //
        $data = tecole_eleves::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }





}

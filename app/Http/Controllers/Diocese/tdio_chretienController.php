<?php

namespace App\Http\Controllers\Diocese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\{tdio_chretien};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tdio_chretienController extends Controller
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

            $data = DB::table('tdio_chretien')            
            ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
            ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
            ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
            ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')
            //Chretien
            ->select("tdio_chretien.id",'noms_chretien','adresse_chretien','contact1_chretien',
            'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
            'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute','date_sacrement',
            'statut_sacrement','tdio_chretien.author','tdio_chretien.refUser',
            'tdio_chretien.active',"tdio_chretien.created_at",

            'nom_communaute','refQuartiers',

            'nom_quartier_dio','refParoisse',
        
            'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
            'refCatParoisse',

            "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien')
            ->where('noms_chretien', 'like', '%'.$query.'%')               
            ->orWhere('nom_communaute', 'like', '%'.$query.'%')
            ->orWhere('nom_quartier_dio', 'like', '%'.$query.'%')
            ->orWhere('nom_paroisse', 'like', '%'.$query.'%')
            ->orderBy("tdio_chretien.noms_chretien", "asc")
            ->paginate(80);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tdio_chretien')            
            ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
            ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
            ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
            ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')
            //Chretien
            ->select("tdio_chretien.id",'noms_chretien','adresse_chretien','contact1_chretien',
            'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
            'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute','date_sacrement',
            'statut_sacrement','tdio_chretien.author','tdio_chretien.refUser',
            'tdio_chretien.active',"tdio_chretien.created_at",

            'nom_communaute','refQuartiers',

            'nom_quartier_dio','refParoisse',
        
            'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
            'refCatParoisse',

            "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien')
            ->orderBy("tdio_chretien.noms_chretien", "asc")
            ->paginate(80);

             return response($data, 200);
            }

        }
    
    public function Profiletdio_chretien($id, Request $request)
    {
        //
        $data = DB::table('tdio_chretien')            
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')
        //Chretien
        ->select("tdio_chretien.id",'noms_chretien','adresse_chretien','contact1_chretien',
        'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
        'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute','date_sacrement',
        'statut_sacrement','tdio_chretien.author','tdio_chretien.refUser',
        'tdio_chretien.active',"tdio_chretien.created_at",

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien')
        ->where([
            ['tdio_chretien.id', $id]
        ])->get();

        return response()->json(['data'  =>  $data]);
        
    }


    function fetch_list_agent()
    {
        $data = DB::table('tdio_chretien')            
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')
        //Chretien
        ->select("tdio_chretien.id",'noms_chretien','adresse_chretien','contact1_chretien',
        'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
        'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute','date_sacrement',
        'statut_sacrement','tdio_chretien.author','tdio_chretien.refUser',
        'tdio_chretien.active',"tdio_chretien.created_at",

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien')
        ->orderBy("noms_chretien", "asc")
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

            // $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            // $slug =$this->makeSlug($stringToSlug);

            tdio_chretien::create([
                'noms_chretien'  =>  $formData->noms_chretien,
                'adresse_chretien'    =>  $formData->adresse_chretien,
                'contact1_chretien'         =>  $formData->contact1_chretien,                
                'contact2_chretien'      =>  $formData->contact2_chretien,                
                'mail_chretien'  =>  $formData->mail_chretien, 
                'nom_pere_chretien'  =>  $formData->nom_pere_chretien,
                'nom_mere_chretien'  =>  $formData->nom_mere_chretien,
                'lieunaissance_chretien'  =>  $formData->lieunaissance_chretien,
                'datenaissance_chretien'  =>  $formData->datenaissance_chretien,
                'photo'         =>  $imageName,
                'refCommunaute'  =>  $formData->refCommunaute,                
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'         =>  $formData->active                       
            ]);
           
            return $this->msgJson('Information ajoutée avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
            // $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            // $slug =$this->makeSlug($stringToSlug);
            tdio_chretien::create([
                'noms_chretien'  =>  $formData->noms_chretien,
                'adresse_chretien'    =>  $formData->adresse_chretien,
                'contact1_chretien'         =>  $formData->contact1_chretien,                
                'contact2_chretien'      =>  $formData->contact2_chretien,                
                'mail_chretien'  =>  $formData->mail_chretien, 
                'nom_pere_chretien'  =>  $formData->nom_pere_chretien,
                'nom_mere_chretien'  =>  $formData->nom_mere_chretien,
                'lieunaissance_chretien'  =>  $formData->lieunaissance_chretien,
                'datenaissance_chretien'  =>  $formData->datenaissance_chretien,
                'photo'         =>  'avatar.png',
                'refCommunaute'  =>  $formData->refCommunaute,                
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'         =>  $formData->active 
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

            // $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            // $slug =$this->makeSlug($stringToSlug);
           
            tdio_chretien::where('id',$formData->id)->update([
                'noms_chretien'  =>  $formData->noms_chretien,
                'adresse_chretien'    =>  $formData->adresse_chretien,
                'contact1_chretien'         =>  $formData->contact1_chretien,                
                'contact2_chretien'      =>  $formData->contact2_chretien,                
                'mail_chretien'  =>  $formData->mail_chretien, 
                'nom_pere_chretien'  =>  $formData->nom_pere_chretien,
                'nom_mere_chretien'  =>  $formData->nom_mere_chretien,
                'lieunaissance_chretien'  =>  $formData->lieunaissance_chretien,
                'datenaissance_chretien'  =>  $formData->datenaissance_chretien,
                'photo'         =>  $imageName,
                'refCommunaute'  =>  $formData->refCommunaute,                
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'         =>  $formData->active
            ]);
            return $this->msgJson('Modifcation avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tdio_chretien::where('id',$formData->id)->update([
                'noms_chretien'  =>  $formData->noms_chretien,
                'adresse_chretien'    =>  $formData->adresse_chretien,
                'contact1_chretien'         =>  $formData->contact1_chretien,                
                'contact2_chretien'      =>  $formData->contact2_chretien,                
                'mail_chretien'  =>  $formData->mail_chretien, 
                'nom_pere_chretien'  =>  $formData->nom_pere_chretien,
                'nom_mere_chretien'  =>  $formData->nom_mere_chretien,
                'lieunaissance_chretien'  =>  $formData->lieunaissance_chretien,
                'datenaissance_chretien'  =>  $formData->datenaissance_chretien,
                'photo'         =>  'avatar.png',
                'refCommunaute'  =>  $formData->refCommunaute,                
                'author'         =>  $formData->author,
                'refUser'         =>  $formData->refUser,
                'active'         =>  $formData->active
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
        $data = DB::table('tdio_chretien')            
        ->join('tdio_communaute' , 'tdio_communaute.id','=','tdio_chretien.refCommunaute')
        ->join('tdio_quartier','tdio_quartier.id','=','tdio_communaute.refQuartiers')
        ->join('tdio_paroisse','tdio_paroisse.id','=','tdio_quartier.refParoisse')
        ->join('tdio_categorie_paroisse','tdio_categorie_paroisse.id','=','tdio_paroisse.refCatParoisse')
        //Chretien
        ->select("tdio_chretien.id",'noms_chretien','adresse_chretien','contact1_chretien',
        'contact2_chretien','mail_chretien','nom_pere_chretien','nom_mere_chretien',
        'lieunaissance_chretien','datenaissance_chretien','photo','refCommunaute','date_sacrement',
        'statut_sacrement','tdio_chretien.author','tdio_chretien.refUser',
        'tdio_chretien.active',"tdio_chretien.created_at",

        'nom_communaute','refQuartiers',

        'nom_quartier_dio','refParoisse',
        
        'nom_paroisse','code_paroisse','description_paroisse','autres_details_paroisse',
        'refCatParoisse',

        "tdio_categorie_paroisse.nom_categorie_paroisse","code_categorie_paroisse")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_chretien, CURDATE()) as age_chretien')
        ->where('tdio_chretien.id', $id)->get();

        
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
        $data = tdio_chretien::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tdio_chretien::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // function RestoreDatatdio_chretien($id, $connected)
    // {
    //     //
    //     $data = tdio_chretien::where('id',$id)->update([
    //         'statut'                =>  0,
    //         'id_user_delete'        =>  $connected,
    //     ]);
    //     return $this->msgJson('Restauration des données avec succès!!!');

    // }





}

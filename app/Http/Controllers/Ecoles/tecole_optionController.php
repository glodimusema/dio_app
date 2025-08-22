<?php

namespace App\Http\Controllers\Ecoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ecoles\{tecole_option};
// use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tecole_optionController extends Controller
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
        
        $data = DB::table('tecole_option')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')  
        ->select("tecole_option.id",'nom_option','code_option','refSection',
        'tecole_option.author','tecole_option.refUser','tecole_option.active',
        "tecole_option.created_at",

        "tecole_section.nom_section","code_section");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tecole_option.nom_option', 'like', '%'.$query.'%')
            ->orderBy("tecole_option.nom_option", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tecole_option_2()
    {
         $data = DB::table('tecole_option')
        ->join('tecole_section','tecole_section.id','=','tecole_option.refSection')  
        ->select("tecole_option.id",'nom_option','code_option','refSection',
        'tecole_option.author','tecole_option.refUser','tecole_option.active',
        "tecole_option.created_at",

        "tecole_section.nom_section","code_section")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //'id','nom_option','code_option','refSection',
    // 'author','refUser','active'

    public function store(Request $request)
    {
        if ($request->id !='') 
        {   # code...
            // update stock_alerte
            $data = tecole_option::where("id", $request->id)->update([
                'nom_option'       =>  $request->nom_option,
                'code_option'    =>  $request->code_option,
                'refSection'    =>  $request->refSection,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
                'active'    =>  $request->active                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tecole_option::create([
                'nom_option'       =>  $request->nom_option,
                'code_option'    =>  $request->code_option,
                'refSection'    =>  $request->refSection,
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
        $data = tecole_option::where('id', $id)->get();
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
        $data = tecole_option::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}

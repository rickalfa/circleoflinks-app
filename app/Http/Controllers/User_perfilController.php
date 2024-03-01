<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User_perfil;

class User_perfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $UserPerfils = User_perfil::all();

        return $UserPerfils->toJson();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $ValidateRe = $request->validate([

            'info'=> 'required|string|min:5|max:255',
            'education'=> 'required|string|min:10|max:255',
            'exp_laboral'=> 'required|string|min:10|max:255',
            'habilidades'=> 'required|string|min:10|max:255',
            'profetion_name'=> 'required|string|min:10|max:255',
            'user_id'=> 'required|unique:User_perfil|exists:App\Models\User,id'

  
           ]);



            $UserPerfil = User_perfil::create($ValidateRe);
        
         }catch(ValidationException $ex){
     
             return response()->json($ex->errors(), 422);
             
     
         }
     

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

          $UserPerfil = User_perfil::findorfail($id);

          return $UserPerfil->toJson();

        }catch(ModelNotFoundException $ex){

            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
        try{
            $findRegister = User_perfil::findOrFail($request->id);
        
               try{
                  $datesInputs = $request->validate( [

                      'id' => 'required|numeric',
                      'info'=> 'string|min:5|max:150',
                      'education'=> 'string|min:5|max:255',
                      'exp_laboral'=> 'string|min:5|max:450',
                      'habilidades'=> 'string|min:5|max:450',
                      'profetion_name'=> 'string|min:5|max:450',
                     
                      ]);

                      /**Metodo hace la actualizacion al registro se gun campo id */
                     $UserPerfil = User_perfil::updateOrCreate(
                        ['id'=> $request->id],
                        $datesInputs
                    );

                     return response()->json(["success-update" =>true, $UserPerfil], 200);

                 }catch(ValidationException $ex){


                      return response()->json($ex->errors(), 422);
                    
                  }

          }catch(ModelNotFoundException $ex){
            
            return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);


          }

       
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        




    }
}

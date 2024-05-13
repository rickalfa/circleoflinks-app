<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use App\Models\User_perfil;

class User_perfilController extends Controller
{

                   /**
* show muestra registro especifico de postulacion oferta laboral
* @OA\Get(
*     path="/api/v1/userperfil",
*     summary="Se muestran los registros de user oferta laborales del user ",
*     tags={"User profile"},

*     @OA\Response(
*         response=200,
*         description="Oferta laboral encontrada",
*         @OA\JsonContent(
*             @OA\Property(property="success", type="boolean", example=false),
*             @OA\Property(property="id", type="integer", example=3),
*             @OA\Property(property="info", type="string", example="closed"),
*             @OA\Property(property="education", type="string", example=" oferta laboral cerrada"),
*             @OA\Property(property="exp_laboral", type="string", example="2024-11-11"),
*             @OA\Property(property="habilidades", type="string", example=" oferta laboral cerrada"),
*             @OA\Property(property="profetion_name", type="string", example="comercio exterior"),
*             @OA\Property( property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
*             @OA\Property( property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
* 
*         )
*      ),
*     @OA\Response(
*         response=404,
*         description="Oferta laboral no encontrada",
* 
*         @OA\JsonContent(
*             @OA\Property(property="success", type="boolean", example=false),
*             @OA\Property(property="message", type="string", example="status Oferta laboral no encontrada con ID: {id}")
*         )
*      )
*     )
* )
*
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
* show muestra registro especifico de postulacion oferta laboral
* @OA\Get(
*     path="/api/v1/userperfil/{id}",
*     summary="Se muestran los registros de user oferta laborales del user ",
*     tags={"User profile"},
*      @OA\parameter(
*          name="id",
*          in="path",
*          required=false   
*        ),
*
*     @OA\Response(
*         response=200,
*         description="Oferta laboral encontrada",
*         @OA\JsonContent(
*             @OA\Property(property="success", type="boolean", example=false),
*             @OA\Property(property="id", type="integer", example=3),
*             @OA\Property(property="info", type="string", example="closed"),
*             @OA\Property(property="education", type="string", example=" oferta laboral cerrada"),
*             @OA\Property(property="exp_laboral", type="string", example="2024-11-11"),
*             @OA\Property(property="habilidades", type="string", example=" oferta laboral cerrada"),
*             @OA\Property(property="profetion_name", type="string", example="comercio exterior"),
*             @OA\Property( property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
*             @OA\Property( property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
* 
*         )
*      ),
*     @OA\Response(
*         response=404,
*         description="Oferta laboral no encontrada",
* 
*         @OA\JsonContent(
*             @OA\Property(property="success", type="boolean", example=false),
*             @OA\Property(property="message", type="string", example="status Oferta laboral no encontrada con ID: {id}")
*         )
*     )
*     
* )
*
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


    public function edit($id)
    {
        //
    }


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
        
        try{

            $userPerfil = User_perfil::findOrFail($id);

            /** Comprovamos si podemos eliminar el registro 
             * si no tiene alguna relacion con otra tabla (foreig-key)
             * que nos impida borrar el registro
             * 
             */
            try {
                
                $userPerfil->delete();

                return response()->json([
                    'success-destroy' => true,
                    'message' => 'empresa destroy'
                ], 200);

            } catch (QueryException $Qe) {
                
                return response()->json(["success" => false, "message" => $Qe->errorInfo], 422);


            }


        }catch(ModelNotFoundException $ex ){

            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }




    }
}

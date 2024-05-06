<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Exception;
use Illuminate\Http\Request;

use App\Models\UserOfertaLaboral;
use App\Http\Requests\StoreUserOfertaLaboralRequest;
use App\Http\Requests\UpdateUserOfertaLaboralRequest;

class UserOfertaLaboralController extends Controller
{


           /**
* show statususer
* @OA\Get(
*     path="/api/v1/userofertalaboral",
*     summary="Se muestran los registros de user oferta laborales del user ",
*     tags={"User oferta laboral"},

*     @OA\Response(
*         response=200,
*         description="descripción o el nombre del código de la petición",
*         @OA\JsonContent(
*             @OA\Property(
*                 type="array",
*                 property="rows",
*                 @OA\Items(
*                     type="object",
*                     @OA\Property(
*                         property="id",
*                         type="integer",
*                         example=2
*                     ),
*                     @OA\Property(
*                         property="user_id",
*                         type="string",
*                         example="description"
*                     ),
*                     @OA\Property(
*                         property="oferta_laboral_id",
*                         type="string",
*                         example="description"
*                     ),
*
*                     @OA\Property(
*                         property="created_at",
*                         type="string",
*                         example="2023-02-23T00:09:16.000000Z"
*                     ),
*                     @OA\Property(
*                         property="updated_at",
*                         type="string",
*                         example="2023-02-23T12:33:45.000000Z"
*                     )
*                 )
*             )
*         )
*     )
* )
*
*/
    public function index()
    {
        $UserOfertaLaborls =UserOfertaLaboral::all();

        return $UserOfertaLaborls->toJson();
    }

 
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
    
       try {

         $userOfertaLaboralvalidate =  $request->validate([
            'user_id'=> 'required|exists:App\Models\User,id',
            'oferta_laboral_id'=> 'required|exists:App\Models\UserOfertaLaboral,id'

        ]);

         $UserOfertaLaboral = UserOfertaLaboral::create( $userOfertaLaboralvalidate );

         return response()->json($UserOfertaLaboral, 200);
        

       } catch (ValidationException $ex) {
        
         return response()->json($ex->errors(), 422);
        

       }
      


    }

  
            /**
* show statususer
* @OA\Get(
*     path="/api/v1/userofertalaboral/{id}",
*     summary="Se muestra el registro de las ofertas laborales del user ",
*     tags={"User oferta laboral"},
*     @OA\parameter(
*       name="id",
*       in="path",
*       required=false   
*        ),
*     @OA\Response(
*         response=200,
*         description="descripción o el nombre del código de la petición",
*         @OA\JsonContent(
*             @OA\Property(
*                 type="array",
*                 property="rows",
*                 @OA\Items(
*                     type="object",
*                     @OA\Property(
*                         property="id",
*                         type="integer",
*                         example=2
*                     ),
*                     @OA\Property(
*                         property="user_id",
*                         type="string",
*                         example="description"
*                     ),
*                     @OA\Property(
*                         property="oferta_laboral_id",
*                         type="string",
*                         example="description"
*                     ),
*
*                     @OA\Property(
*                         property="created_at",
*                         type="string",
*                         example="2023-02-23T00:09:16.000000Z"
*                     ),
*                     @OA\Property(
*                         property="updated_at",
*                         type="string",
*                         example="2023-02-23T12:33:45.000000Z"
*                     )
*                 )
*             )
*         )
*     )
* )
*
*/
    public function show($id)
    {
     
        try {
            //code...

            $UserOfertaLaboral = UserOfertaLaboral::findorfail($id);


            return $UserOfertaLaboral->toJson();
    

        } catch (Exception  $th) {
           
            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ],400);

        }
    

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function edit(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }


   /**
* update user Oferta Laboral
* @OA\Patch(
*     path="/api/v1/userofertalaboral",
*     summary="Se actualiza el registro que es especificado en el campo id ",
*     tags={"User oferta laboral"},
*     @OA\parameter(
*       name="id",
*       in="query",
*       required=true    
*        ),
*     @OA\parameter(
*       name="user_id",
*       in="query",
*       required=true    
*        ),
*     @OA\parameter(
*       name="oferta_laboral_id",
*       in="query",
*       required=true    
*        ),
*     @OA\parameter(
*       name="idescription",
*       in="query",
*       required=true    
*        ),
*     @OA\Response(
*         response=200,
*         description="descripción o el nombre del código de la petición",
*         @OA\JsonContent(
*             @OA\Property(
*                 type="array",
*                 property="rows",
*                 @OA\Items(
*                     type="object",
*                     @OA\Property(
*                         property="id",
*                         type="number",
*                         example="1"
*                     ),
*                     @OA\Property(
*                         property="name",
*                         type="string",
*                         example="Aderson Felix"
*                     ),
*                     @OA\Property(
*                         property="email",
*                         type="string",
*                         example="angelshamael@gmail.com"
*                     ),
*                     @OA\Property(
*                         property="created_at",
*                         type="string",
*                         example="2023-02-23T00:09:16.000000Z"
*                     ),
*                     @OA\Property(
*                         property="updated_at",
*                         type="string",
*                         example="2023-02-23T12:33:45.000000Z"
*                     )
*                 )
*             )
*         )
*    ),
*
*     @OA\Response(
*         response=400,
*         description="descripción o el nombre del código de la petición",
*         @OA\JsonContent(

*                     type="object",
*                     @OA\Property(
*                         property="id",
*                         type="number",
*                         example="1"
*                     ),
*                     @OA\Property(
*                         property="name",
*                         type="string",
*                         example="Aderson Felix"
*                     ),
*                     @OA\Property(
*                         property="email",
*                         type="string",
*                         example="angelshamael@gmail.com"
*                     ),
*                     @OA\Property(
*                         property="created_at",
*                         type="string",
*                         example="2023-02-23T00:09:16.000000Z"
*                     ),
*                     @OA\Property(
*                         property="updated_at",
*                         type="string",
*                         example="2023-02-23T12:33:45.000000Z"
*                     )
*                 
*             
*         )
*
*     )
*
*    
* )
*
*/
    public function update(Request $request)
    {


        try {
            $datesValidate = $request->validate([
    
                'id' => 'required|numeric',
                'user_id'=> 'numeric|exists:App\Models\User,id',
                'oferta_laboral_id'=> 'numeric|exists:App\Models\UserOfertaLaboral,id',
                'description' => 'string|min:5|max:500'

            ]);

         
            try {
                
            
                $existsregister = UserOfertaLaboral::findOrFail($request->id);
      

                $UserOfertaLaboral = UserOfertaLaboral::updateOrCreate(
                    ['id' => $request->id],
                    $datesValidate);

                return response()->json(["success-update" => true, $UserOfertaLaboral], 200);


                
            } catch (ModelNotFoundException $ex ){

                return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);

   

         }

            
        } catch (ValidationException $Ex) {
            
           
            return response()->json($Ex->errors(), 422);
           

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }
}

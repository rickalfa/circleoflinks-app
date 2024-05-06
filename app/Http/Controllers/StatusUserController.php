<?php

namespace App\Http\Controllers;

use App\Models\Status_user;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Exception;

class StatusUserController extends Controller
{
 
        /**
* show statususer
* @OA\Get(
*     path="/api/v1/statususer",
*     summary="Se muestra el registro status user ",
*     tags={"Status users"},

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
*                         property="name",
*                         type="stringr",
*                         example="status name"
*                     ),
*                     @OA\Property(
*                         property="description",
*                         type="string",
*                         example="description"
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
*     )
* )
*
*/
    public function index()
    {
        $statusUsers = Status_user::all();

        return $statusUsers->toJson();
        

    }

  
    public function create()
    {
        //
    }

   /** 
    * agregar Status user
    * @OA\Post(
    *     path="/api/v1/statususer",
    *     tags={"Status users"},
*    @OA\RequestBody(
*         description="User object to be created",
*         required=true,
*         @OA\JsonContent(
*                     @OA\Property(
*                         property="name",
*                         type="string",
*                         example="baneado"
*                     ),
*                     @OA\Property(
*                         property="description",
*                         type="string",
*                         example="el usuario no puede comentar o crear posts"
*                     ),
*          )
*     ),
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
    *                         property="updated_at",
    *                         type="string",
    *                         example="2023-02-23T12:33:45.000000Z"
    *                     )
    *                 )
    *             )
    *         )
    *     )
    * )
    */  
    public function store(Request $request)
    {
        
        try {
            
            $datesValidates = $request->validate([

                'name'=>'required|unique:Status_user|string|min:5|max:150',
                'description'=>'required|string|min:5|max:355',
               

            ]);
            
            $StatusUser = Status_user::create($datesValidates);

            return response()->json($StatusUser, 200);


        } catch (ValidationException $ex) {
          
            return response()->json($ex->errors(), 422);
        

        }

    }

  
        /**
* show statususer
* @OA\Get(
*     path="/api/v1/statususer/{id}",
*     summary="Se muestra el registro status user ",
*     tags={"Status users"},
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
*                         property="name",
*                         type="stringr",
*                         example="status name"
*                     ),
*                     @OA\Property(
*                         property="description",
*                         type="string",
*                         example="description"
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
*     )
* )
*
*/
    public function show($id)
    {
        
        try{

      
            $StatusUser = Status_user::findOrFail($id);

            return $StatusUser->toJson();



        }catch(Exception $th){

            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ],400);

        }


    }

   
    public function edit($id)
    {
        
    }

   /**
* update user
* @OA\Patch(
*     path="/public/api/v1/statususer/",
*     summary="Se muestra un solo registro user ",
*     tags={"Status users"},
*    @OA\RequestBody(
*         description="User object to be created",
*         required=true,
*         @OA\JsonContent(
*                     @OA\Property(
*                         property="id",
*                         type="number",
*                         example="1"
*                     ),
*          )
*     ),
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
*                         property="success-update",
*                         type="boolean",
*                         example=true
*                     ),
*                     @OA\Property(
*                         property="updated_at",
*                         type="string",
*                         example="2023-02-23T12:33:45.000000Z"
*                     )
*                 )
*             )
*         )
*     ),
*      @OA\Response(
*         response=400,
*         description="Bad request",
*         @OA\JsonContent(
*                     @OA\Property(
*                         property="success-update",
*                         type="number",
*                         example="1"
*                     )
*                )
*     )
* )
*
*/
    public function update(Request $request)
    {

        try {
            
            $existsRegister = Status_user::findOrFail($request->id);

            try {
                

                $datesValidate = $request->validate([

                    'id'=>'required|numeric',
                    'name'=>'string|min:5|max:150',
                    'description'=>'string|min:5|max:355',
                   
                ]);

                $StatusUserUpdate = Status_user::updateOrCreate(
                    ['id'=> $request->id],
                    $datesValidate
                );

                return response()->json(['success-update'=> true, $StatusUserUpdate], 200);
    

            } catch (ValidationException $Ex) {

                return response()->json($Ex->errors(), 422);

            }

        } catch (ModelNotFoundException $ex) {
           
            return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);


        }

        
    }

  
    /**
* Delete StatusUser
* @OA\Delete(
*     path="/public/api/v1/statususer/",
*     summary="Se muestra un solo registro user ",
*     tags={"Status users"},
*     @OA\parameter(
*       name="id",
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
*                         property="message",
*                         type="number",
*                         example="1"
*                     ),
*                     @OA\Property(
*                         property="name",
*                         type="string",
*                         example="Aderson Felix"
*                     )
*                 )
*             )
*         )
*     )
* )
*
*/
    public function destroy($id)
    {
    
        try {
            
            $statusUser = Status_user::findOrFail($id);

            try {
                
                $statusUser->delete();

                return response()->json([
                    'success-destroy' => true,
                    'message' => 'status user destroy'
                ], 200);

            } catch (QueryException $Qe) {

                return response()->json(["success" => false, "message" => $Qe->errorInfo], 422);

            }

        } catch (ModelNotFoundException $ex) {
            
            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }
    }
}

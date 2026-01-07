<?php

namespace App\Http\Controllers;

use App\Models\UserApp;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;

use App\Http\Requests\StoreUserAppRequest;
use App\Http\Requests\UpdateUserAppRequest;


class UserAppController extends Controller
{
 
 /**
* all users Json
* @OA\Get(
*     path="/api/v1/users",
*     tags={"Users"},
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
*     )
* )
*
*/
    public function index()
    {
      
        
        $users = UserApp::all();

        return $users->toJson();


    }

    public function create()
    {
        //
    }

     /** 
    * agregar usuario
    * @OA\Post(
    *     path="/api/v1/users",
    *     tags={"Users"},
    *     @OA\Parameter(
    *        in="path",
    *       name="name",
    *       required=true
    *       ),
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
    *                         property="password",
    *                         type="string",
    *                         example="mypass_1234$"
    *                     ),
    *                     @OA\Property(
    *                         property="address",
    *                         type="string",
    *                         example="calle olivos 2345"
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

        try{
        $datesRequestValidate = $request->validate([

            'name'=>'required|string|min:5|max:150',
            'email'=>'required|unique:empresa|string|min:5|max:150',
            'password'=>'string|min:5|max:150',
            'address'=>'string|min:5|max:150'
        ]);

        $User = UserApp::create($datesRequestValidate );

        return response()->json([
            "succes" => true,
            "user" => $User
            ]);


        }catch(Exception $ex){
            
            return response()->json($ex->getMessage(), 422);
            
    
        }


        
    }

    /**
* show user
* @OA\Get(
*     path="/api/v1/users/{id}",
*     summary="Se muestra un solo registro user ",
*     tags={"Users"},
*     @OA\parameter(
*       name="id",
*       in="path",
*       required=true    
*        ),
*     @OA\Response(
*         response=200,
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
*                         property="address",
*                         type="string",
*                         example="calle ventura"
*                     ),

*                 
*             
*         )
*     )
* )
*
*/


    public function show($id)
    {
        try {

            $User = UserApp::findorfail($id);

            return response()->json([
                "succes" => true,
                "user" => $User
                ]);

        } catch (Exception $th) {
            
            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ], 400);
        }

        

     

    }



  /**
* update user
* @OA\Patch(
*     path="/api/v1/users/",
*     summary="Se muestra un solo registro user ",
*     tags={"Users"},
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
*     )
* )
*
*/
    public function update(Request $request)
    {

        try {
            
            $existsregister = UserApp::findOrFail($request->id);

          
            try {

                $datesvalidate = $request->validate([

                    'name'=>'required|string|min:5|max:150',
                    'email'=>'required|unique:empresa|string|min:5|max:150',
                    'password'=>'string|min:5|max:150',
                    'address'=>'string|min:5|max:150',
                    'id' => 'required|numeric'
                ]);
                
                $UserAppUpdate = UserApp::updateOrCreate(
                    ['id' => $request->id],
                    $datesvalidate
                );

                return response()->json(["success-update" => true,"user" => $datesvalidate], 200);   


                
            } catch (ValidationException $Ex) {
                
                return response()->json($Ex->errors(), 422);


            }
            
        } catch (ModelNotFoundException $ex) {
           
            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }
        
    }

    
    public function edit($id)
    {
        
    }


    public function destroy($id)
    {
        



    }
}

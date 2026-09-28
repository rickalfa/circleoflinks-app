<?php

namespace App\Http\Controllers;

use App\Models\UserApp;
use App\Services\ResponseService;
use App\Http\Resources\UserAppResource;

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
      *     summary="Obtiene un listado paginado de usuarios",
      *     @OA\Parameter(
      *         name="page",
      *         in="query",
      *         required=false,
      *         description="Numero de pagina",
      *         @OA\Schema(type="integer", example=1)
      *     ),
      *     @OA\Parameter(
      *         name="per_page",
      *         in="query",
      *         required=false,
      *         description="Cantidad de registros por pagina",
      *         @OA\Schema(type="integer", example=10)
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Listado paginado de usuarios",
      *         @OA\JsonContent(
      *             @OA\Property(property="success", type="boolean", example=true),
      *             @OA\Property(property="status", type="integer", example=200),
      *             @OA\Property(property="message", type="string", example="Listado obtenido"),
      *             @OA\Property(property="data", type="object"),
      *             @OA\Property(property="meta", type="object")
      *         )
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Error en el servidor",
      *         @OA\JsonContent(
      *             @OA\Property(property="success", type="boolean", example=false),
      *             @OA\Property(property="message", type="string", example="Error en el servidor")
      *         )
      *     )
      * )
      *
      */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $users = UserApp::paginate($perPage, ['*'], 'page', $page);

            return ResponseService::success(
                UserAppResource::collection($users),
                'Listado obtenido',
                200,
                [
                    'current_page' => $users->currentPage(),
                    'total'        => $users->total(),
                    'last_page'    => $users->lastPage()
                ]
            );
        } catch (Exception $e) {
            return ResponseService::error(
                'Error en el servidor',
                500,
                $e->getMessage()
            );
        }

    }

    public function create()
    {
        //
    }
     /** 
     * agregar usuario (protegido por API token)
     * @OA\Post(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="Crea un usuario",
     *     description="Registra un usuario. Requiere API token.",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Bearer {token}",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="Aderson Felix"),
     *             @OA\Property(property="email", type="string", example="angelshamael@gmail.com"),
     *             @OA\Property(property="password", type="string", example="mypass_1234$"),
     *             @OA\Property(property="address", type="string", example="calle olivos 2345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario creado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacion",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
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

        $user = UserApp::create($datesRequestValidate );

        return ResponseService::success(
            new UserAppResource($user),
            'Usuario creado correctamente',
            200
        );


        }catch(ValidationException $ex){

            return ResponseService::error('Error de validacion', 422, $ex->errors());

        }catch(Exception $ex){
            
            return ResponseService::error('Error en el servidor', 500, $ex->getMessage());
            
    
        }


        
    }


     /**
     * show user
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Obtiene un usuario por ID",
     *     tags={"Users"},
     *     @OA\parameter(
     *       name="id",
     *       in="path",
     *       required=true    
     *        ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Usuario encontrado"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     *
     */public function show($id)
    {
        try {

            $user = UserApp::findorfail($id);

            return ResponseService::success(
                new UserAppResource($user),
                "Usuario encontrado",
                200
            );

        } catch (Exception $th) {
            
            return ResponseService::error(
                "Usuario no encontrado",
                404,
                $th->getMessage()
            );
        

        } catch (Exception $th) {
                
                return response()->json([

                    'success'=> false,
                    'message' => $th->getMessage()


                ], 400);
            }

        

     

    }
     /**
     * update user (protegido por API token)
     * @OA\Patch(
     *     path="/api/v1/users",
     *     summary="Actualiza un usuario",
     *     tags={"Users"},
     *     description="Actualiza los campos enviados del usuario. Requiere API token.",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Bearer {token}",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Aderson Felix"),
     *             @OA\Property(property="email", type="string", example="angelshamael@gmail.com"),
     *             @OA\Property(property="password", type="string", example="mypass_1234$"),
     *             @OA\Property(property="address", type="string", example="calle ventura")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success-update", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacion",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     *
     */public function update(Request $request)
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






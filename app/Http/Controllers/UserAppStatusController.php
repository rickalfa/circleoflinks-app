<?php

namespace App\Http\Controllers;

use App\Models\UserAppStatus;
use App\Services\ResponseService;
use App\Http\Resources\UserAppStatusResource;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserAppStatusController extends Controller
{
    /**
     * index UserAppStatus
     * @OA\Get(
     *     path="/api/v1/userappstatus",
     *     summary="Obtiene un listado paginado de estados de usuario",
     *     tags={"User app status"},
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
     *         description="Listado paginado de estados de usuario",
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

            $status = UserAppStatus::paginate($perPage, ['*'], 'page', $page);

            return ResponseService::success(
                UserAppStatusResource::collection($status),
                'Listado obtenido',
                200,
                [
                    'current_page' => $status->currentPage(),
                    'total'        => $status->total(),
                    'last_page'    => $status->lastPage()
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
     * crear user app status (protegido por API token)
     * @OA\Post(
     *     path="/api/v1/userappstatus",
     *     tags={"User app status"},
     *     summary="Crea un estado de usuario",
     *     description="Crea un estado de usuario. Requiere API token.",
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
     *             required={"name","description"},
     *             @OA\Property(property="name", type="string", example="Activo"),
     *             @OA\Property(property="description", type="string", example="Usuario activo en la plataforma")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro creado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Registro creado"),
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
        try {
            $data = $request->validate([
                'name' => 'required|unique:user_app_status|string|min:5|max:150',
                'description' => 'required|string|min:5|max:355'
            ]);

            $status = UserAppStatus::create($data);

            return ResponseService::success(
                new UserAppStatusResource($status),
                'Registro creado',
                200
            );
        } catch (ValidationException $ex) {
            return ResponseService::error('Error de validacion', 422, $ex->errors());
        } catch (Exception $ex) {
            return ResponseService::error('Error en el servidor', 500, $ex->getMessage());
        }
    }

    /**
     * show user app status
     * @OA\Get(
     *     path="/api/v1/userappstatus/{id}",
     *     summary="Obtiene un estado de usuario por ID",
     *     tags={"User app status"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Registro encontrado"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Registro no encontrado")
     *         )
     *     )
     * )
     *
     */
    public function show($id)
    {
        try {
            $status = UserAppStatus::findOrFail($id);

            return ResponseService::success(
                new UserAppStatusResource($status),
                'Registro encontrado',
                200
            );
        } catch (ModelNotFoundException $ex) {
            return ResponseService::error('Registro no encontrado', 404, $ex->getMessage());
        } catch (Exception $ex) {
            return ResponseService::error('Error en el servidor', 500, $ex->getMessage());
        }
    }

    public function edit(UserAppStatus $userAppStatus)
    {
        //
    }

    /**
     * update user app status (protegido por API token)
     * @OA\Patch(
     *     path="/api/v1/userappstatus",
     *     summary="Actualiza un estado de usuario",
     *     tags={"User app status"},
     *     description="Actualiza los campos enviados. Requiere API token.",
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
     *             @OA\Property(property="name", type="string", example="Suspendido"),
     *             @OA\Property(property="description", type="string", example="Usuario con cuenta suspendida")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro actualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Registro actualizado"),
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
     */
    public function update(Request $request)
    {
        try {
            UserAppStatus::findOrFail($request->id);

            $data = $request->validate([
                'id' => 'required|numeric',
                'name' => 'string|min:5|max:150',
                'description' => 'string|min:5|max:355'
            ]);

            $status = UserAppStatus::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            return ResponseService::success(
                new UserAppStatusResource($status),
                'Registro actualizado',
                200
            );
        } catch (ValidationException $ex) {
            return ResponseService::error('Error de validacion', 422, $ex->errors());
        } catch (ModelNotFoundException $ex) {
            return ResponseService::error('Registro no encontrado', 404, $ex->getMessage());
        } catch (Exception $ex) {
            return ResponseService::error('Error en el servidor', 500, $ex->getMessage());
        }
    }

    public function destroy(UserAppStatus $userAppStatus)
    {
        return ResponseService::error('Metodo no disponible', 405);
    }
}

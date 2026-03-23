<?php

namespace App\Http\Controllers;


use App\Models\Proyectos;
use App\Services\ResponseService;
use App\Http\Resources\ProyectoResource;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;





use Illuminate\Http\Request;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Lista los proyectos con paginacion.
     *
     * @OA\Get(
     *     path="/api/v1/proyectos",
     *     tags={"Proyectos"},
     *     summary="Obtiene el listado paginado de proyectos",
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
     *         description="Listado de proyectos",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="listado de Proyectos obtenidos"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
    
     
        try {

              $perPage = $request->input('per_page', 10);
              $page = $request->input('page', 1);

              $proyectos = Proyectos::paginate($perPage,['*'],'page', $page );

              return ResponseService::success(
                  $proyectos,
                  'listado de Proyectos obtenidos',
                  200,
                  [
                        'current_page' => $proyectos->currentPage(),
                        'total'        => $proyectos->total(),
                        'last_page'    => $proyectos->lastPage()
                  ]



              );
            
        } catch (Exception $e) {
           return ResponseService::error('Error en el servidor',
                 500,
                  $e->getMessage());
        }


    }

    /**
     * Crea un nuevo proyecto (protegido por API token).
     *
     * @OA\Post(
     *     path="/api/v1/proyectos",
     *     tags={"Proyectos"},
     *     summary="Crea un proyecto",
     *     description="Registra un proyecto asociado a una empresa. Requiere API token.",
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
     *             required={"name","description","date_finish","empresa_id"},
     *             @OA\Property(property="name", type="string", example="Proyecto Web"),
     *             @OA\Property(property="description", type="string", example="Desarrollo de portal corporativo"),
     *             @OA\Property(property="date_finish", type="string", format="date", example="2025-12-31"),
     *             @OA\Property(property="empresa_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto creado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Proyecto creado correctamente")
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validateData = $request->validate([
                'name' => 'required|string|min:5|max:150',
                'description' => 'required|string|min:5|max:355',
                'date_finish' => 'required|date',
                'empresa_id' => 'required|exists:App\Models\Empresa,id'
            ]);

            $proyecto = Proyectos::create($validateData);

            return ResponseService::success(
                $proyecto,
                'Proyecto creado correctamente',
                200
            );

        }catch(ValidationException $ex){

            return response()->json($ex->errors(), 422);

        }catch(Exception $e){

            return ResponseService::error(
                'Error en el servidor',
                500,
                $e->getMessage()
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    /**
     * Obtiene el detalle de un proyecto por ID.
     *
     * @OA\Get(
     *     path="/api/v1/proyectos/{id}",
     *     tags={"Proyectos"},
     *     summary="Obtiene un proyecto por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del proyecto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Proyecto y su empresa obtenidos correctamente"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Proyecto no encontrado")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
    
        try {
        
         $proyecto = Proyectos::with('empresa')->findOrFail($id);

         return ResponseService::success(
                new ProyectoResource($proyecto),
                'Proyecto y su empresa obtenidos correctamente',
                200
            );
          
        


        } catch (Exception $e) {

          return ResponseService::error(
             'Proyecto no encontrado',
              404
              );
            
        }



    }

    /**
     * Actualiza un proyecto existente (protegido por API token).
     *
     * @OA\Patch(
     *     path="/api/v1/proyectos",
     *     tags={"Proyectos"},
     *     summary="Actualiza un proyecto",
     *     description="Actualiza los campos enviados del proyecto. Requiere API token.",
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
     *             @OA\Property(property="id", type="integer", example=10),
     *             @OA\Property(property="name", type="string", example="Proyecto Web v2"),
     *             @OA\Property(property="description", type="string", example="Actualizacion del portal"),
     *             @OA\Property(property="date_finish", type="string", format="date", example="2026-03-01"),
     *             @OA\Property(property="empresa_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto actualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success-update", type="boolean", example=true)
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyectos $proyectos)
    {
        try{

            $existsRegister = Proyectos::findOrFail($request->id);

            try{

                $datesValidate = $request->validate([
                    'id' => 'required|numeric',
                    'name' => 'string|min:5|max:150',
                    'description' => 'string|min:5|max:355',
                    'date_finish' => 'date',
                    'empresa_id' => 'exists:App\Models\Empresa,id'
                ]);

                $proyectoUpdate = Proyectos::updateOrCreate(
                    ['id' => $request->id],
                    $datesValidate
                );

                return response()->json(["success-update" => true, $proyectoUpdate], 200);

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
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyectos $proyectos)
    {
        //
    }
}

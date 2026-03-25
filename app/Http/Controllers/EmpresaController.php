<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Models\Empresa;
use App\Services\ResponseService;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\OfertaLaboralResource;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;




class EmpresaController extends Controller
{

    
/**
 * index Empresa
 *
 * @OA\Get(
 *     path="/api/v1/empresa",
 *     summary="Obtiene un listado paginado de empresas",
 *     tags={"Empresa"},
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Número de página",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         required=false,
 *         description="Cantidad de registros por página",
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Empresas encontradas",
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Listado de empresas obtenido correctamente"),
 *
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=3),
 *                     @OA\Property(property="name", type="string", example="Cencocud"),
 *                     @OA\Property(property="email", type="string", example="contacto@empresa.cl"),
 *                     @OA\Property(property="avatar", type="string", example="comercio_exterior.png"),
 *                     @OA\Property(property="address", type="string", example="Street Brlmoor #3453"),
 *                     @OA\Property(property="rubro", type="string", example="Transporte comercio local"),
 *                     @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
 *                     @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
 *                 )
 *             ),
 *
 *             @OA\Property(property="errors", type="object", nullable=true),
 *
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=120),
 *                 @OA\Property(property="last_page", type="integer", example=12)
 *             )
 *         )
 *     )
 * )
 */

    public function index(Request $request)
    {
 
     try {
                $perPage = $request->input('per_page', 10);
                $page = $request->input('page', 1);

                $empresas = Empresa::paginate($perPage,['*'],'page', $page );

                // Usamos el Resource para transformar la colección
                return ResponseService::success(
                    $empresas, 
                    'Listado obtenido',
                    200,
                    [
                        'current_page' => $empresas->currentPage(),
                        'total'        => $empresas->total(),
                        'last_page'    => $empresas->lastPage()
                    ]
                );
            } catch (Exception $e) {

                return ResponseService::error('Error en el servidor',
                 500, $e->getMessage());
            }
        

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
     * Crea una nueva empresa usando API token (Sanctum).
     *
     * @OA\Post(
     *     path="/api/v1/empresa",
     *     summary="Crea una empresa",
     *     tags={"Empresa"},
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
     *             required={"name","email","rubro"},
     *             @OA\Property(property="name", type="string", example="Mi Empresa SPA"),
     *             @OA\Property(property="email", type="string", example="contacto@empresa.cl"),
     *             @OA\Property(property="avatar", type="string", example="logo.png"),
     *             @OA\Property(property="address", type="string", example="Calle 123"),
     *             @OA\Property(property="rubro", type="string", example="Tecnologia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa creada",
     *         @OA\JsonContent(
     *             @OA\Property(property="succes", type="boolean", example=true)
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
        
        //$datesRequest = $request->validated();
    //**validamos los datos OBLIGATORIOS enviados  */
     try{

         $validateDates =$request->validate( [
           'name'=> 'required|string|min:5|max:150',
           'email'=>'required|unique:empresa|string|min:5|max:150',
           'avatar'=> 'string|min:5|max:150',
           'address'=>'string|min:5|max:150',
           'rubro'=>'required|string|min:5|max:150'
         ]);

      
         $empresa = Empresa::create($validateDates);


         return ResponseService::success(
                $empresa,
                "Empresa Creada",
                200
                
             );


       }catch(ValidationException $ex){

         return response()->json($ex->errors(), 422);
        

       }
  


    }


     /**
     * Mostramos la empresa especificada por el id
     * @OA\Get(
     *     path="/api/v1/empresa/{id}",
     *     summary="Obtienes los datos del registro empresa ",
     *     tags={"Empresa"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Empresa encontrada",
     *         @OA\JsonContent(
     *                
     *                    @OA\Property(property="success", type="boolean"),
     *                @OA\Property(property="status", type="integer"),
     *                @OA\Property(property="message", type="string"),
     *                @OA\Property(property="data", 
     *                                      
     *                                      @OA\Property(property="id", type="integer", example=3),
     *                                      @OA\Property(property="name", type="string", example=" cencocud"),
     *                                      @OA\Property(property="email", type="string", example=" oferta laboral cerrada"),
     *                                      @OA\Property(property="avatar", type="string", example="comercio exterior"),
     *                                      @OA\Property(property="address", type="string", example="street brlmoor #3453"),
     *                                      @OA\Property(property="rubro", type="string", example="transporte comercio local"),
     *                                      @OA\Property( property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *                                      @OA\Property( property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *                          ),
     *                @OA\Property(property="errors", type="object", nullable=true),
     *                @OA\Property(property="meta",type="object", nullable=true )
     *                       
     *                       
     *            
     *         )
     *      )
     *
     *     
     * )
     *
     */
    public function show($id)
    {

       
        try{
            $Empresa = Empresa::findorfail($id);

            return ResponseService::success(
                $Empresa,
                "Empresa encontrada",
                200
                
             );

         } catch (Exception $th) {
             return ResponseService::Error(
                "error al buscar la empresa",
                404,
                $th->getMessage()
             );
         }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Actualiza una empresa existente (protegido por API token).
     *
     * @OA\Patch(
     *     path="/api/v1/empresa",
     *     summary="Actualiza una empresa",
     *     tags={"Empresa"},
     *     description="Actualiza los campos enviados para una empresa. Requiere API token.",
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
     *             @OA\Property(property="name", type="string", example="Empresa Actualizada"),
     *             @OA\Property(property="email", type="string", example="nuevo@empresa.cl"),
     *             @OA\Property(property="avatar", type="string", example="logo.png"),
     *             @OA\Property(property="address", type="string", example="Calle 123"),
     *             @OA\Property(property="rubro", type="string", example="Tecnologia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa actualizada",
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
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /**
         * Comprobamos si el registro existe
         */
        try{

            $existsregister = Empresa::findOrFail($request->id);

            try {
                
                $datesvalidate = $request->validate([

                    'name'=> 'string|min:5|max:150',
                    'email'=>'string|min:5|max:150',
                    'avatar'=> 'string|min:5|max:150',
                    'address'=>'string|min:5|max:150',
                    'rubro'=>'string|min:5|max:150',
                    'id' => 'required|numeric'
                   ]);
                   
                   $empresaUdpate = Empresa::updateOrCreate(
                    ['id' => $request->id],
                    $datesvalidate
                   );
                 
                return response()->json(["success-update" => true, $empresaUdpate]);   

               
            } catch (ValidationException $Ex) {
                
                return response()->json($Ex->errors(), 422);


            }


            //error si el modelo que se busca no existe 
        }catch(ModelNotFoundException $ex){

               return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $Empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        
              $empresaregister = Empresa::findOrFail($id);

              $empresaregister->delete();


             
             return response()->json([
                 'success-destroy' => true,
                 'message' => 'empresa destroy'
             ], 200);

          }catch(ModelNotFoundException $ex){

            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


          }

    }



    /**
 * Obtener empresa con sus ofertas laborales
 * @OA\Get(
 * path="/api/v1/empresa/{id}/ofertalaboral",
 * summary="Obtiene luna paginacion de las Ofertas Laborales de la empresa con {id} ",
 * tags={"Empresa"},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * description="ID de la empresa",
 * required=true,
 * @OA\Schema(type="integer")
 * ),
 * @OA\Response(
 * response=200,
 * description="Empresa y ofertas encontradas",
 * @OA\JsonContent(
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="message", type="string", example="Empresa y sus ofertas obtenidas"),
 * @OA\Property(property="data", type="object",
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Empresa X"),
 * @OA\Property(property="email", type="string", example="contacto@empresa.com"),
 * @OA\Property(property="ofertas", type="array",
 * description="Listado de ofertas asociadas",
 * @OA\Items(
 * @OA\Property(property="id", type="integer", example=101),
 * @OA\Property(property="titulo", type="string", example="Desarrollador Fullstack"),
 * @OA\Property(property="salario", type="integer", example=1500000),
 * @OA\Property(property="fecha_limite", type="string", format="date", example="2024-12-31")
 * )
 * )
 * )
 * )
 * ),
 * @OA\Response(
 * response=404,
 * description="Empresa no encontrada"
 * )
 * )
 */
public function showWithOffers($id)
{
    try {
        $empresa = Empresa::findOrFail($id);
        
        // Paginamos directamente la relación
        $ofertas = $empresa->oferta_laborals()->paginate(10); 

        return ResponseService::success(
                OfertaLaboralResource::collection($ofertas),
                "Ofertas de la empresa con id = " .$id. " obtenidas",
                200,
                [
                    'total' => $ofertas->total(),
                    'current_page' => $ofertas->currentPage(),
                    'last_page' => $ofertas->lastPage()
                ]
           );

    } catch (Exception $th) {
        return ResponseService::error(
            "Error al buscar la empresa o sus ofertas",
            404,
            $th->getMessage()
        );
    }
}


}

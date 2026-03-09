<?php

namespace App\Http\Controllers;

use App\Models\OfertaLaboral;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use App\Services\ResponseService;
use App\Http\Resources\OfertaLaboralResource;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class OfertaLaboralController extends Controller
{
 
    /**
     * Lista las ofertas laborales activas con paginación.
     *
     * @OA\Get(
     *     path="/api/v1/ofertalaboral",
     *     tags={"Oferta laboral"},
     *     summary="Obtiene el listado paginado de ofertas laborales",
     *     description="Devuelve la colección paginada de ofertas y metadatos útiles para navegación.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Cantidad de registros por página",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de ofertas laborales paginado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Listado de ofertas obtenido"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error inesperado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error inesperado")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
    
       try {
        
            $perPage = $request->input('per_page', 10);
            $page    = $request->input('page', 1);

            $ofertasLaborales = OfertaLaboral::paginate($perPage, ['*'], 'page', $page);

            return ResponseService::success(
                $ofertasLaborales,
                'Listado de paginas de Ofertas laborales Obtenidos',
                200,
                  [
                        'current_page' => $ofertasLaborales->currentPage(),
                        'total'        => $ofertasLaborales->total(),
                        'last_page'    => $ofertasLaborales->lastPage()
                  ]
            );
        
       

       } catch (Exception $e) {
        //thr
         return ResponseService::error(
                'Error inesperado',
                 500,
                  $e->getMessage());
       }
        

         

        

    }

    /**
     * Crea una nueva oferta laboral con los datos validados del solicitante.
     *
     * @OA\Post(
     *     path="/api/v1/ofertalaboral",
     *     tags={"Oferta laboral"},
     *     summary="Registra una oferta laboral",
     *     description="Valida los datos obligatorios y guarda la oferta laboral en la base de datos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "title",
     *                 "name",
     *                 "description",
     *                 "date_expire",
     *                 "salary",
     *                 "status_oferta_laboral_id",
     *                 "empresa_id",
     *                 "user_oferta_laboral_id"
     *             },
     *             @OA\Property(property="title", type="string", example="Asistente de marketing"),
     *             @OA\Property(property="name", type="string", example="Marketing digital"),
     *             @OA\Property(property="description", type="string", example="Responsable de campañas digitales"),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2024-11-11"),
     *             @OA\Property(property="salary", type="number", example=1500000),
     *             @OA\Property(property="status_oferta_laboral_id", type="integer", example=1),
     *             @OA\Property(property="empresa_id", type="integer", example=2),
     *             @OA\Property(property="user_oferta_laboral_id", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta laboral creada",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="message", type="string", example="Oferta laboral creada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
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
        
        //$datesRequest = $request->all();

        try{
        $datesInputs = $request->validate( [

            'title'=>'required|string|min:5|max:150',
            'name'=>'required|string|min:5|max:150',
            'description'=>'required|string|min:5|max:355',
            'date_expire'=>'required|date',
            'salary' => 'required|numeric',
            'status_oferta_laboral_id' => 'required|exists:App\Models\Status_oferta_laboral,id',
            'empresa_id'=>'required|exists:App\Models\Empresa,id',
            'user_oferta_laboral_id'=>'required|exists:App\Models\UserOfertaLaboral,id' 

        ]);


        $OfertaLaboral = OfertaLaboral::create($datesInputs);

        return response()->json($OfertaLaboral, 200); 


        
       }catch(ValidationException $ex){

        return response()->json($ex->errors(), 422);
        


       }

    }

     
    /**
     * Devuelve el detalle completo de una oferta laboral específica.
     *
     * @OA\Get(
     *     path="/api/v1/ofertalaboral/{id}",
     *     tags={"Oferta laboral"},
     *     summary="Obtiene una oferta por su id",
     *     description="Incluye el estado, compañía y campos principales de la oferta.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la oferta laboral",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta laboral encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Oferta laboral encontrada"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="title", type="string", example="Dev Junior Front"),
     *                 @OA\Property(property="name", type="string", example="Trabajo desarrollo"),
     *                 @OA\Property(property="description", type="string", example="Se necesita con urgencia"),
     *                 @OA\Property(property="salary", type="number", example=2000000),
     *                 @OA\Property(property="date_expire", type="string", format="date", example="2024-11-11")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta laboral no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Oferta laboral no encontrada con ID: {id}")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        //

        try{

            
           $ofertaLaboral = OfertaLaboral::with(['empresa', 'statusofertalaboral'])->findOrFail($id);

   
           return ResponseService::success(
                new OfertaLaboralResource($ofertaLaboral),
                ' Oferta laboral encontrada',
                200

            );


        } catch(Exception $th) {

           return ResponseService::Error(
                "error al buscar la oferta laboral",
                404,
                $th->getMessage()
             );
        }

        


    }
    /**
     * Actualiza una oferta laboral existente.
     *
     * @OA\Patch(
     *     path="/api/v1/ofertalaboral",
     *     tags={"Oferta laboral"},
     *     summary="Actualiza los datos de una oferta laboral",
     *     description="Valida los campos enviados y aplica los cambios sobre el registro identificado por su id.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=3),
     *             @OA\Property(property="title", type="string", example="Dev Semi Senior Back"),
     *             @OA\Property(property="name", type="string", example="Back-end"),
     *             @OA\Property(property="description", type="string", example="Actualiza APIs"),
     *             @OA\Property(property="salary", type="number", example=2500000),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status_oferta_laboral_id", type="integer", example=2),
     *             @OA\Property(property="empresa_id", type="integer", example=1),
     *             @OA\Property(property="user_oferta_laboral_id", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta laboral actualizada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success-update", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Oferta laboral actualizada")
     *         )
     *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Error de validación o registro inexistente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string"),
    *             @OA\Property(property="errors", type="object")
    *         )
    *     )
     * )
     */
    public function update(Request $request, OfertaLaboral $oferta_laboral)
    {
        /**vaidamos si existe el registro segun el id de la request */
        try{

             $existsregister = OfertaLaboral::findOrFail($request->id);

            try{

                $datesvalidate = $request->validate([

                    'id' => 'required|numeric', 
                    'title'=>'string|min:5|max:150',
                    'name'=>'string|min:5|max:150',
                    'description'=>'string|min:5|max:355',
                    'date_expire'=>'date',
                    'salary' => 'numeric',
                    'status_oferta_laboral_id' => 'exists:App\Models\Status_oferta_laboral,id',
                    'empresa_id'=>'exists:App\Models\Empresa,id',
                    'user_oferta_laboral_id'=>'exists:App\Models\UserOfertaLaboral,id'
                    
        
                ]);

                        /**Metodo hace la actualizacion al registro se gun campo id */
                     $OfertaLaboralUpdate = OfertaLaboral::updateOrCreate(
                        ['id' => $request->id],
                        $datesvalidate
                     );


                return response()->json(["success-update" => true, $OfertaLaboralUpdate], 200);

            }catch(ValidationException $Ex){

                return response()->json($Ex->errors(), 422);


            }



        }catch(ModelNotFoundException $ex){

            return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);

        }


    }

    /**
     * Elimina permanentemente una oferta laboral.
     *
     * @OA\Delete(
     *     path="/api/v1/ofertalaboral/{id}",
     *     tags={"Oferta laboral"},
     *     summary="Elimina una oferta por ID",
     *     description="Borra la oferta indicada mientras no existan restricciones de llave foránea.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la oferta a eliminar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success-destroy", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="empresa destroy")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró la oferta",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No existe la oferta")
     *         )
     *     )
     * )
     *
     * @param  \App\Models\OfertaLaboral  $oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        /**si existe el ID si no lanzara una exception */
        try{
        
            $oferta_laboral = OfertaLaboral::findOrFail($id);

               /** Comprovamos si podemos eliminar el registro 
             * si no tiene alguna relacion con otra tabla (foreig-key)
             * que nos impida borrar el registro
             * 
             */

            try{
              
                $oferta_laboral->delete();

                return response()->json([
                    'success-destroy' => true,
                    'message' => 'empresa destroy'
                ], 200);

            }catch(QueryException $Qe){

                return response()->json(["success" => false, "message" => $Qe->errorInfo], 422);



            }


     

        }catch(ModelNotFoundException $ex){

            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }

    }


    /**
     * Devuelve una oferta junto con la empresa propietaria y su estatus.
     *
     * @OA\Get(
     *     path="/api/v1/ofertalaboral/{id}/empresa",
     *     tags={"Oferta laboral"},
     *     summary="Obtiene una oferta con sus relaciones",
     *     description="Incluye la empresa y el estado definido en la relación de la oferta.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la oferta laboral",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta y empresa encontradas",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="oferta y empresa encontrados"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
    *     @OA\Response(
    *         response=404,
    *         description="No se encontró la oferta o la empresa",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=false),
    *             @OA\Property(property="status", type="integer", example=404),
    *             @OA\Property(property="message", type="string", example="Error al buscar la empresa a la que pertenece la oferta laboral")
    *         )
    *     )
     * )
     */
    public function showOfertaLaboralWithEmpresa($id)
    {

         try {
         
           $oferta = OfertaLaboral::with(['empresa', 'status_oferta_laborals'])->findOrFail($id);

             return ResponseService::success(
                 new OfertaLaboralResource($oferta),
                 "oferta y emrpesa encontrados",
                 200

                 );


         } catch (Exception $e) {
         
            return ResponseService::error(
                    " error al buscar la empresa a la que pertenece La oferta laboral",
                    404,
                    $e->getMessage()
                    );

          }



    }


}

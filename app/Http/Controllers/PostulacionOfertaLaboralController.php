<?php

namespace App\Http\Controllers;

use App\Models\PostulacionOfertaLaboral;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Services\ResponseService;

use App\Http\Requests\StorePostulacion_oferta_laboralRequest;
use App\Http\Requests\UpdatePostulacion_oferta_laboralRequest;
use App\Models\Status_user;
use App\Http\Resources\PostulacionOfertaLaboralResource;


use Illuminate\Database\Eloquent\Model;

class PostulacionOfertaLaboralController extends Controller
{
 
    
     /**
     * show postulacion oferta laboral
     *
     * @OA\Get(
     *     path="/api/v1/postulacionofertalaboral",
     *     tags={"Postulacion oferta laboral"},
     *     summary="Se muestran los registros de user oferta laborales del user ",
     *     
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
     *         description="Oferta laboral encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="id", type="integer", example=3),
     *             @OA\Property(property="name", type="string", example="closed"),
     *             @OA\Property(property="description", type="string", example=" oferta laboral cerrada"),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2024-11-11"),
     *             @OA\Property(property="oferta_laboral_id", type="integer", example=10)
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
     *     
     * )
     *
     */
    public function index(Request $request)
    {

    try{

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);        

            $PostulacionOfertasL = PostulacionOfertaLaboral::paginate($perPage, ['*'], 'page', $page);

        return ResponseService::success(
               $PostulacionOfertasL,
               'Listado obtenido',
               200,
               [

                        'current_page' => $PostulacionOfertasL->currentPage(),
                        'total'        => $PostulacionOfertasL->total(),
                        'last_page'    => $PostulacionOfertasL->lastPage()

               ]

         );


        }catch(Exception $e){

        return ResponseService::error(
                'error en el servidor',
                500,
                $e->getMessage()

            );

        }
            
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Crea una postulacion a una oferta laboral (protegido por API token).
     *
     * @OA\Post(
     *     path="/api/v1/postulacionofertalaboral",
     *     tags={"Postulacion oferta laboral"},
     *     summary="Crea una postulacion",
     *     description="Registra una postulacion asociada a una oferta laboral. Requiere API token.",
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
     *             required={"name","description","date_expire","oferta_laboral_id"},
     *             @OA\Property(property="name", type="string", example="Postulacion Frontend"),
     *             @OA\Property(property="description", type="string", example="Me interesa la vacante"),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2026-04-30"),
     *             @OA\Property(property="oferta_laboral_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Postulacion creada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
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
     * 
     */
    public function store(StorePostulacion_oferta_laboralRequest $request)
    {

       try{
         $datesInputs = $request->validate( [

             'name'=> 'required|string|min:5|max:255',
             'description'=> 'required|string|min:5|max:355',
             'date_expire'=> 'required|string|min:5|max:255',
             'oferta_laboral_id'=> 'required|exists:App\models\Oferta_laboral,id'


         ]);


         $PostulacionOfertaLaboral = PostulacionOfertaLaborall::create($datesInputs);

         return $PostulacionOfertaLaboral;

       }catch(ValidationException $ex){

          
        return response()->json($ex->errors(), 422);
        

       }

      

        

    }

     /**
     * show muestra registro especifico de postulacion oferta laboral
     * @OA\Get(
     *     path="/api/v1/postulacionofertalaboral/{id}",
     *     summary="Se muestran los registros de user oferta laborales del user ",
     *     tags={"Postulacion oferta laboral"},
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
     *             @OA\Property(property="name", type="string", example="closed"),
     *             @OA\Property(property="description", type="string", example=" oferta laboral cerrada"),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2024-11-11"),
     *             @OA\Property(property="oferta_laboral_id", type="integer", example=10)
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
     *     )
     * )
     *
     */
    public function show($id)
    {
     

      try {
            
           $postulacion = PostulacionOfertaLaboral::with([
               'ofertalaboral.empresa',
               'ofertalaboral.statusofertalaboral'
           ])->findOrFail($id);

           return ResponseService::success(
                new PostulacionOfertaLaboralResource($postulacion),
                "Postulacion encontrada",
                200

            );

        } catch(Exception $th) {

           return ResponseService::Error(
                "error al buscar la postualacion a oferta laboral",
                404,
                $th->getMessage()
             );
        }
        
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function edit(PostulacionOfertaLaboral $postulacion_oferta_laboral)
    {
        //
    }

    /**
     * Actualiza una postulacion (protegido por API token).
     *
     * @OA\Patch(
     *     path="/api/v1/postulacionofertalaboral",
     *     tags={"Postulacion oferta laboral"},
     *     summary="Actualiza una postulacion",
     *     description="Actualiza los campos enviados de la postulacion. Requiere API token.",
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
     *             @OA\Property(property="id", type="integer", example=5),
     *             @OA\Property(property="name", type="string", example="Postulacion Actualizada"),
     *             @OA\Property(property="description", type="string", example="Actualizo mi interes"),
     *             @OA\Property(property="date_expire", type="string", format="date", example="2026-05-01"),
     *             @OA\Property(property="oferta_laboral_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Postulacion actualizada",
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
     * @param  \App\Http\Requests\UpdatePostulacion_oferta_laboralRequest  $request
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostulacionOfertaLaboral $postulacion_oferta_laboral)
    {
        
        
        try{


            $esxitsregister = PostulacionOfertaLaboral::findOrFail($request->id);

            try {
                
                $datesvalidate = $request->validate([

                    'id' => 'required|numeric',
                    'name'=> 'string|min:5|max:255',
                    'description'=> 'string|min:5|max:455',
                    'date_expire'=> 'string|min:5|max:255',
                    'oferta_laboral_id'=> 'exists:App\models\Oferta_laboral,id'
       


                ]);
                
                $postulacionOfertaLabroalUpdate = Postulacion_oferta_laboral::updateOrCreate(
                    ['id' => $request->id],
                    $datesvalidate
                );

                return response()->json(["success-update" => true, $postulacionOfertaLabroalUpdate], 200);


            } catch (ValidationException $Ex) {
                
                return response()->json($Ex->errors(), 422);

            }



        }catch(ModelNotFoundException $ex){

            return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);


        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**siexiste el ID si no lanzara una exception */

        try {
            
            $postulacionDelet = Postulacion_oferta_laboral::findorfail($id)->delete();

                  /** Comprovamos si podemos eliminar el registro 
             * si no tiene alguna relacion con otra tabla (foreig-key)
             * que nos impida borrar el registro
             * 
             */
            try {
                
                $postulacionDelet->delete();

                return response()->json([
                    'success-destroy' => true,
                    'message' => 'empresa destroy'
                ], 200);


            } catch (QueryException $Qe) {
                
                return response()->json(["success" => false, "message" => $Qe->errorInfo], 422);


            }
        

        } catch (ModelNotFoundException $ex) {
            
            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }
      
    }
}

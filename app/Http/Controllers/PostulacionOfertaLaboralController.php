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


use Illuminate\Database\Eloquent\Model;

class PostulacionOfertaLaboralController extends Controller
{
 
    
           /**
* show postulacion oferta laboral
* @OA\Get(
*     path="/api/v1/postulacionofertalaboral",
*     summary="Se muestran los registros de user oferta laborales del user ",
*     tags={"Postulacion oferta laboral"},

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
 *     )
*     )
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostulacion_oferta_laboralRequest  $request
     * @return \Illuminate\Http\Response
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
     
             $PostulacionOfertaL = PostulacionOfertaLaboral::findOrFail($id);
     

              return ResponseService::success(
                $PostulacionOfertaL,
                "Postulacion encontrada",
                200
              );
                 
                 
          } catch (Exception $th) {
             
                 return ResponseService::error(
                    "error al buscar la postualacion a oferta laboral",
                    400,
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
     * Update the specified resource in storage.
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

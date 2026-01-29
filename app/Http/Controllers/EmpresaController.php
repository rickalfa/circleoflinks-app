<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Models\Empresa;
use App\Services\ResponseService;


use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;




class EmpresaController extends Controller
{

    
    /**
* show Empresa
* @OA\Get(
*     path="/api/v1/empresa",
*     summary="Obtines una paginacion con 10 registros ",
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
*                @OA\Property(property="meta", 
*                       @OA\Property(property="current_page", type="integer"),
*                       @OA\Property(property="per_page", type="integer"),
*                       @OA\Property(property="total", type="integer"),
*                       @OA\Property(property="last_page", type="integer")
*                   )
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
    public function index(Request $request)
    {
    try {


         

         $paginationnum = $request->input('pagination');

         if(isset($paginationnum )){

               $paginationcount = intval($paginationnum);

           if( $paginationcount > 0){

          
                $response = Empresa::paginate($paginationnum);

                return ResponseService::success(
                            $response->items(),
                            'Listado de empresas obtenido correctamente paginacion',
                            200,
                            [
                                'current_page' => $response->currentPage(),
                                'per_page'     => $response->perPage(),
                                'total'        => $response->total(),
                                'last_page'    => $response->lastPage()
                            ]
                        );


             }else{   
                 $response = Empresa::paginate(3);
        
                  }

                       $response = Empresa::paginate(1);


                        return ResponseService::success(
                            $response->items(),
                            'Listado de empresas obtenido correctament',
                            200,
                            [
                                'current_page' => $response->currentPage(),
                                'per_page'     => $response->perPage(),
                                'total'        => $response->total(),
                                'last_page'    => $response->lastPage()
                            ]
                        );

         }else{

         
                 $response = Empresa::paginate(10);

                        return ResponseService::success(
                            $response->items(),
                            'Listado de empresas obtenido correctamente',
                            200,
                            [
                                'current_page' => $response->currentPage(),
                                'per_page'     => $response->perPage(),
                                'total'        => $response->total(),
                                'last_page'    => $response->lastPage()
                            ]
                        );
         }


        

            
        } catch (Exception $th) {


            return ResponseService::error(
              'Error al obtener las empresas',
             500,
            $th->getMessage()
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
        //
    }

    /**
     * Store a newly created resource in storage.
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


         return response()->json(["succes" => true]);

       }catch(ValidationException $ex){

         return response()->json($ex->errors(), 422);
        

       }
  


    }


    /**
* show  empresa 
* @OA\Get(
*     path="/api/v1/empresa/{id}",
*     summary="Se muestra un solo registro Empresa ",
*     tags={"Empresa"},
*     @OA\parameter(
*       name="id",
*       in="path",
*       required=false   
*        ),

*     @OA\Response(
*         response=200,
*         description="Oferta laboral encontrada",
*         @OA\JsonContent(
*             @OA\Property(property="success", type="boolean", example=false),
*             @OA\Property(property="id", type="integer", example=3),
*             @OA\Property(property="name", type="string", example="closed"),
*             @OA\Property(property="email", type="string", example=" oferta laboral cerrada"),
*             @OA\Property(property="avatar", type="string", example="comercio exterior"),
*             @OA\Property(property="address", type="string", example="street brlmoor #3453"),
*             @OA\Property(property="rubro", type="string", example="transporte comercio local"),
*             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
*             @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
* 
*         )
*      )
*     
*  )
*
*/
    public function show($id)
    {

       
        try{
            $Empresa = Empresa::findorfail($id);

            return $Empresa->toJson();

         } catch (Exception $th) {
             return response()->json([

                 'success'=> false,
                 'message' => $th->getMessage()


             ], 400);
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
     * Update the specified resource in storage.
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
}

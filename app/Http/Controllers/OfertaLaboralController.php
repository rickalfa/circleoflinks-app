<?php

namespace App\Http\Controllers;

use App\Models\Oferta_laboral;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class OfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $OfertaLaboral = Oferta_laboral::all(); 

        return $OfertaLaboral->toJson();

    }

    /**
     * Store a newly created resource in storage.
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


        $OfertaLaboral = Oferta_laboral::create($datesInputs);

        return response()->json($OfertaLaboral, 200); 


        
       }catch(ValidationException $ex){

        return response()->json($ex->errors(), 422);
        


       }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Oferta_laboral  $oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        try{

            
           $OfertaLaboral = Oferta_laboral::findorfail($id);
   
           return $OfertaLaboral->toJson();


        } catch(Exception $th) {

            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ],400);
        }

        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Oferta_laboral  $oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Oferta_laboral $oferta_laboral)
    {
        /**vaidamos si existe el registro segun el id de la request */
        try{

             $existsregister = Oferta_laboral::findOrFail($request->id);

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
                     $OfertaLaboralUpdate = Oferta_laboral::updateOrCreate(
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Oferta_laboral  $oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        /**si existe el ID si no lanzara una exception */
        try{
        
            $oferta_laboral = Oferta_laboral::findOrFail($id);

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
}

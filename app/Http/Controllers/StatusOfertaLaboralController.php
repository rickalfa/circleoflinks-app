<?php

namespace App\Http\Controllers;

use App\Models\Status_oferta_laboral;
use App\Http\Requests\StoreStatus_oferta_laboralRequest;
use App\Http\Requests\UpdateStatus_oferta_laboralRequest;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;

class StatusOfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $statusofertalaboral = Status_oferta_laboral::all();

        return $statusofertalaboral->toJson();

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
     * @param  \App\Http\Requests\StoreStatus_oferta_laboralRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

 
        //
      try{

         $validateData = $request->validate([

          'name' => 'required|string|min:5|max:150',
          'description' => 'required|string'

         ]);

      

        $statusofertalab = Status_oferta_laboral::create($validateData);
   
          return  response()->json(["succes" => true]);

        }catch( ValidationException $ex){
  
          
          return  response()->json($ex->errors(), 422) ;
  
  
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status_oferta_laboral  $status_ofeta_laboral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $statusofertalaboral = Status_oferta_laboral::findOrFail($id);

            return $statusofertalaboral->toJson();

        }catch(Exception $ex){

            return response()->json([

                'success'=> false,
                'message' => $ex->getMessage()


            ],400);


        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status_oferta_laboral  $status_ofeta_laboral
     * @return \Illuminate\Http\Response
     */
    public function edit(Status_oferta_laboral $status_ofeta_laboral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatus_oferta_laboralRequest  $request
     * @param  \App\Models\Status_oferta_laboral  $status_ofeta_laboral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status_oferta_laboral $status_ofeta_laboral)
    {
        
        try{

            $existsregister = Status_oferta_laboral::findOrFail($request->id);

            try{

                $datesValidate = $request->validate([

                    'id' => 'required|numeric',
                    'name' => 'string|min:5|max:150',
                    'description' => 'string'

                ]);

                $statusofertalaboralUpdate = Status_oferta_laboral::updateOrCreate(
                    ['id' => $request->id],
                    $datesValidate
                );

                return response()->json(["success-update"=> true], 200);



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
     * @param  \App\Models\Status_oferta_laboral  $status_ofeta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

           $statusOfertaLaboral = Status_oferta_laboral::findOrFail($id);

           $statusOfertaLaboral->delete();

           
           return response()->json([
               'success-destroy' => true,
               'message' => 'status_oferta_laboral destroy'
           ], 200);


        }catch(ModelNotFoundException $ex){

            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


            
        }

    }
}

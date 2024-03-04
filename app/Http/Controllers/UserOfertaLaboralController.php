<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Exception;
use Illuminate\Http\Request;

use App\Models\UserOfertaLaboral;
use App\Http\Requests\StoreUserOfertaLaboralRequest;
use App\Http\Requests\UpdateUserOfertaLaboralRequest;

class UserOfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserOfertaLaborls =UserOfertaLaboral::all();

        return $UserOfertaLaborls->toJson();
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
     * @param  \App\Http\Requests\StoreUserOfertaLaboralRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
       try {

         $userOfertaLaboralvalidate =  $request->validate([
            'user_id'=> 'required|exists:App\Models\User,id',
            'oferta_laboral_id'=> 'required|exists:App\Models\UserOfertaLaboral,id'

        ]);

         $UserOfertaLaboral = UserOfertaLaboral::create( $userOfertaLaboralvalidate );

         return response()->json($UserOfertaLaboral, 200);
        

       } catch (ValidationException $ex) {
        
         return response()->json($ex->errors(), 422);
        

       }
      


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
        try {
            //code...

            $UserOfertaLaboral = UserOfertaLaboral::findorfail($id);


            return $UserOfertaLaboral->toJson();
    

        } catch (Exception  $th) {
           
            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ],400);

        }
    

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function edit(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserOfertaLaboralRequest  $request
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        try {
            $datesValidate = $request->validate([
    
                'id' => 'required|numeric',
                'user_id'=> 'numeric|exists:App\Models\User,id',
                'oferta_laboral_id'=> 'numeric|exists:App\Models\UserOfertaLaboral,id',
                'description' => 'string|min:5|max:500'

            ]);

         
            try {
                
            
                $existsregister = UserOfertaLaboral::findOrFail($request->id);
      

                $UserOfertaLaboral = UserOfertaLaboral::updateOrCreate(
                    ['id' => $request->id],
                    $datesValidate);

                return response()->json(["success-update" => true, $UserOfertaLaboral], 200);


                
            } catch (ModelNotFoundException $ex ){

                return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);

   

         }

            
        } catch (ValidationException $Ex) {
            
           
            return response()->json($Ex->errors(), 422);
           

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }
}

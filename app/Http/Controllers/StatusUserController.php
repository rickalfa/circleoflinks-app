<?php

namespace App\Http\Controllers;

use App\Models\Status_user;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Exception;

class StatusUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusUsers = Status_user::all();

        return $statusUsers->toJson();
        

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
        
        try {
            
            $datesValidates = $request->validate([

                'name'=>'required|string|min:5|max:150',
                'description'=>'required|string|min:5|max:355',
               

            ]);
            
            $StatusUser = Status_user::create($datesValidates);

            return response()->json($StatusUser, 200);


        } catch (ValidationException $ex) {
          
            return response()->json($ex->errors(), 422);
        

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        try{

      
            $StatusUser = Status_user::findOrFail($id);

            return $StatusUser->toJson();



        }catch(Exception $th){

            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ],400);

        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try {
            
            $existsRegister = Status_user::findOrFail($request->id);

            try {
                

                $datesValidate = $request->validate([

                    'id'=>'required|numeric',
                    'name'=>'string|min:5|max:150',
                    'description'=>'string|min:5|max:355',
                   
                ]);

                $StatusUserUpdate = Status_user::updateOrCreate(
                    ['id'=> $request->id],
                    $datesValidate
                );

                return response()->json(['success-update'=> true, $StatusUserUpdate], 200);
    

            } catch (ValidationException $Ex) {

                return response()->json($Ex->errors(), 422);

            }

        } catch (ModelNotFoundException $ex) {
           
            return response()->json(["success-update" => false, "message" => $ex->getMessage()], 422);


        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        try {
            
            $statusUser = Status_user::findOrFail($id);

            try {
                
                $statusUser->delete();

                return response()->json([
                    'success-destroy' => true,
                    'message' => 'status user destroy'
                ], 200);

            } catch (QueryException $Qe) {

                return response()->json(["success" => false, "message" => $Qe->errorInfo], 422);

            }

        } catch (ModelNotFoundException $ex) {
            
            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


        }
    }
}

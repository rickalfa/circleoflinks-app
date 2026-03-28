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
 
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $statusUsers = Status_user::paginate($perPage, ['*'], 'page', $page);

            return ResponseService::success(
                $statusUsers,
                'Listado obtenido',
                200,
                [
                    'current_page' => $statusUsers->currentPage(),
                    'total'        => $statusUsers->total(),
                    'last_page'    => $statusUsers->lastPage()
                ]
            );
        } catch (Exception $e) {

            return ResponseService::error(
                'Error en el servidor',
                500,
                $e->getMessage()
            );
        }

    }

  
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        try {
            
            $datesValidates = $request->validate([

                'name'=>'required|unique:Status_user|string|min:5|max:150',
                'description'=>'required|string|min:5|max:355',
               

            ]);
            
            $StatusUser = Status_user::create($datesValidates);

            return response()->json($StatusUser, 200);


        } catch (ValidationException $ex) {
          
            return response()->json($ex->errors(), 422);
        

        }

    }

  
    
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

   
    public function edit($id)
    {
        
    }


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



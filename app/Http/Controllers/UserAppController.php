<?php

namespace App\Http\Controllers;

use App\Models\UserApp;

use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use App\Http\Requests\StoreUserAppRequest;
use App\Http\Requests\UpdateUserAppRequest;

class UserAppController extends Controller
{
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = UserApp::all();

        return $users->toJson();


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

        try{
        $datesRequestValidate = $request->validate([

            'name'=>'required|string|min:5|max:150',
            'email'=>'required|unique:empresa|string|min:5|max:150',
            'password'=>'string|min:5|max:150',
            'address'=>'string|min:5|max:150'
        ]);

        $User = UserApp::create($datesRequestValidate );

        return response()->json([
            "succes" => true,
            "user" => $User
            ]);


    }catch(ValidationException $ex){
        
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
        try {

            $User = UserApp::findorfail($id);

            return response()->json([
                "succes" => true,
                "user" => $User
                ]);

        } catch (ValidationException $th) {
            
            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ], 400);
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

        /**
         * validamos si existe el registro
         */
        try {
            
            $existsregister = UserApp::findOrFail($request->id);

            /**
             * Validamos los inputs
             */
            try {

                $datesvalidate = $request->validate([

                    'name'=>'required|string|min:5|max:150',
                    'email'=>'required|unique:empresa|string|min:5|max:150',
                    'password'=>'string|min:5|max:150',
                    'address'=>'string|min:5|max:150',
                    'id' => 'required|numeric'
                ]);
                
                $UserAppUpdate = UserApp::updateOrCreate(
                    ['id' => $request->id],
                    $datesvalidate
                );

                return response()->json(["success-update" => true,"user" => $datesvalidate], 200);   


                
            } catch (ValidationException $Ex) {
                
                return response()->json($Ex->errors(), 422);


            }
            
        } catch (ModelNotFoundException $ex) {
           
            return response()->json(["success" => false, "message" => $ex->getMessage()], 422);


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
        



    }
}

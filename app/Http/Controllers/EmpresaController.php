<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Models\Empresa;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    

        try {

            $Empresas = Empresa::all();

            return $Empresas->toJson();
            
        } catch (\ErrorException $th) {
            return response()->json([

                'success'=> false,
                'message' => $th->getMessage()


            ]);
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
     * Display the specified resource.
     *
     * @param  \App\Models\empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       
        try{
            $Empresa = Empresa::findorfail($id);

            return $Empresa->toJson();

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

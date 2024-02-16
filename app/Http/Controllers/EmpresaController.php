<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
            
        } catch (Exception $th) {
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
        
        $datesRequest = $request->all();

        $datesInputs = [
            'name'=>$datesRequest['name'],
            'email'=>$datesRequest['email'],
            'avatar'=>$datesRequest['avatar'],
            'address'=>$datesRequest['address'],
            'rubro'=>$datesRequest['rubro']

        ];

        $empresa = Empresa::create($datesInputs);


        if(isset($empresa->id))
        {
            $response = ['created'=>'done'];

            return json_encode($response);

        }else{

            
            $response = ['created'=>'fail'];

            return json_encode($response);


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
    public function update(Request $request, Empresa $empresa)
    {
        //




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $Empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $Empresa)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Oferta_laboral;
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
        
        $datesRequest = $request->all();

        $datesInputs = [

            'title'=>$datesRequest['title'],
            'name'=>$datesRequest['name'],
            'description'=>$datesRequest['description'],
            'date_expire'=>date("Y-m-d H:i:s"),
            'salary' => $datesRequest['salary'],
            'status_oferta_laboral_id' => $datesRequest['status_oferta_laboral_id'],
            'empresa_id'=> $datesRequest['empresa_id'],
            'user_oferta_laboral_id'=>$datesRequest['user_oferta_laboral_id']

        ];


        $OfertaLaboral = Oferta_laboral::create($datesInputs);

        if(isset($OfertaLaboral->id))
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Oferta_laboral  $oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oferta_laboral $oferta_laboral)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Postulacion_oferta_laboral;
use App\Http\Requests\StorePostulacion_oferta_laboralRequest;
use App\Http\Requests\UpdatePostulacion_oferta_laboralRequest;

class PostulacionOfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $PostulacionOfertasL = Postulacion_oferta_laboral::all();

        return $PostulacionOfertasL->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostulacion_oferta_laboralRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostulacion_oferta_laboralRequest $request)
    {

        $datesRequest = $request->all();

        $datesInputs = [

            'name'=> $datesRequest['name'],
            'description'=> $datesRequest['description'],
            'date_expire'=> $datesRequest['date_expire'],
            'oferta_laboral_id'=>$datesRequest['oferta_laboral_id']


        ];


        $PostulacionOfertaLaboral = Postulacion_oferta_laboral::create($datesInputs);


        if(isset($PostulacionOfertaLaboral->id))
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
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $PostulacionOfertaL = Postulacion_oferta_laboral::findOrFail($id);

        return $PostulacionOfertaL->toJson();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function edit(Postulacion_oferta_laboral $postulacion_oferta_laboral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostulacion_oferta_laboralRequest  $request
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostulacion_oferta_laboralRequest $request, Postulacion_oferta_laboral $postulacion_oferta_laboral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postulacion_oferta_laboral  $postulacion_oferta_laboral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $postulacionDelet = Postulacion_oferta_laboral::findorfail($id)->delete();

        
    }
}

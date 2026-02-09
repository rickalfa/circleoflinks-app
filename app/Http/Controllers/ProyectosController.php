<?php

namespace App\Http\Controllers;


use App\Models\Proyectos;
use App\Services\ResponseService;
use App\Http\Resources\ProyectoResource;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;





use Illuminate\Http\Request;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
     
        try {

              $perPage = $request->input('per_page', 10);
              $page = $request->input('page', 1);

              $proyectos = Proyectos::paginate($perPage,['*'],'page', $page );

              return ResponseService::success(
                  $proyectos,
                  'listado de Proyectos obtenidos',
                  200,
                  [
                        'current_page' => $proyectos->currentPage(),
                        'total'        => $proyectos->total(),
                        'last_page'    => $proyectos->lastPage()
                  ]



              );
            
        } catch (Exception $e) {
           return ResponseService::error('Error en el servidor',
                 500,
                  $e->getMessage());
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        try {
        
         $proyecto = Proyectos::with('empresa')->findOrFail($id);

         return ResponseService::success(
                new ProyectoResource($proyecto),
                'Proyecto y su empresa obtenidos correctamente',
                200
            );
          
        


        } catch (Exception $e) {

          return ResponseService::error(
             'Proyecto no encontrado',
              404
              );
            
        }



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyectos $proyectos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyectos $proyectos)
    {
        //
    }
}

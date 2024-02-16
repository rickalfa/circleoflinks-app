<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User_perfil;

class User_perfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $UserPerfils = User_perfil::all();

        return $UserPerfils->toJson();


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

        $ValidateRe = $request->validate([

            'info'=> 'required|max:255',
            'education'=> 'required|max:255',
            'exp_laboral'=> 'required|max:255',
            'habilidades'=> 'required|max:255',
            'profetion_name'=> 'required|max:255',
            'user_id'=> 'required|max:255'


        ]);


        $datesRequest = $request->all();

        $datesInputs = [

        'info'=> $datesRequest['info'],
        'education'=> $datesRequest['education'],
        'exp_laboral'=> $datesRequest['exp_laboral'],
        'habilidades'=> $datesRequest['habilidades'],
        'profetion_name'=> $datesRequest['profetion_name'],
        'user_id'=> $datesRequest['user_id']
        ];



        $UserPerfil = User_perfil::create($datesInputs);
        
        if(isset($UserPerfil->id))
        {
            $response = ['created'=>'done',
                          'perfiluser'=> $UserPerfil];

            return json_encode($response);

        }else{

            
            $response = ['created'=>'fail'];

            return json_encode($response);


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
        
        $UserPerfil = User_perfil::findorfail($id);

        

        return $UserPerfil->toJson();

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
    public function update(Request $request, User_perfil $UserPerfil)
    {
        
        $datesRequest = $request->all();

        $datesInputs = [

            'info'=> $datesRequest['info'],
            'education'=> $datesRequest['education'],
            'exp_laboral'=> $datesRequest['exp_laboral'],
            'habilidades'=> $datesRequest['habilidades'],
            'profetion_name'=> $datesRequest['profetion_name'],
            'user_id'=> $datesRequest['user_id']
            ];

       $UserPerfil = User_perfil::updateOrCreate(
           ['id'=> $datesRequest['id']],
           $datesInputs
       );

      //$UserPerfil->update($datesRequest);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

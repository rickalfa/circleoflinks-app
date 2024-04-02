<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use PhpParser\JsonDecoder;

class UserController extends Controller
{
    /**
     * Login usuario con Email y pass
     */

     public function loginUser($email, $pass)
     {
        $response = array("login-state"=>"", "userauth"=>"");

        $useremail = User::where('email', $email)->first();

       // foreach($useremail as $user){
//
       //     $userid = $user;
//
       // }

       // dd($useremail->password);
        

        if(isset($useremail->id))
        {

            if($useremail->password == $pass)
            {
              $response['login-state'] = "success";

              $response['userauth'] = $useremail;

            }else{
                
                $response['login-state'] = "fail";
            }
           

        }else{

            $response['login-state'] = "fail";

        }


        $jsonresponse = json_encode($response);

        return $jsonresponse;


     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = User::all();

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

        $datesRequest = $request->all();

        $datesInputs = [
            'name'=>$datesRequest['name'],
            'email'=>$datesRequest['email'],
            'password'=>$datesRequest['password'],
            'address'=>$datesRequest['address']
        ];

        $User = User::create($datesInputs);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = User::findorfail($id);

        return $user_id;

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
    public function update(Request $request, $id)
    {

        
        
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

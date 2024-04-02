<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\User_perfil;
use App\Models\UserApp;
use Database\Factories\User_perfilFactory;

class User_perfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $Users_id = array();

        $Users = UserApp::all();

        foreach ($Users as $User) {
            
              array_push($Users_id, $User->id);

        }

        $count_user = count($Users_id);

        User_perfil::factory()
        ->count($count_user)
        ->state(new Sequence(
            fn ($sequence) =>['user_id' => $Users_id[$sequence->index]],
        ))
        ->create();


    

    }
}

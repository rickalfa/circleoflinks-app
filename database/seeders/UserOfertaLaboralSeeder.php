<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\UserApp;

use App\Models\UserOfertaLaboral;



class UserOfertaLaboralSeeder extends Seeder
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


        UserOfertaLaboral::factory()
        ->count($count_user)
        ->state(new Sequence(
            fn ($sequence) =>['user_id' => $Users_id[$sequence->index]],
        ))
        ->create();




    }
}

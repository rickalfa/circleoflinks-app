<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\Empresa;
use App\Models\User;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $Users_id = array();

        $Users = User::all();

        foreach ($Users as $User) {
            
              array_push($Users_id, $User->id);

        }

        $count_user = count($Users_id);

        Empresa::factory()
        ->count($count_user)
        ->create();


    }
}

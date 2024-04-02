<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\UserAppStatus;
use App\Models\UserApp;

class UserAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $Userappstatus_id = array();

        $UserAppStatus = UserAppStatus::all();


        foreach($UserAppStatus as $UserAppStatu)
        {

            array_push($Userappstatus_id, $UserAppStatu->id);

        }

        $count_userappstatus = count($Userappstatus_id);
     

        UserApp::factory()
        ->count(7)
        ->state(new Sequence(
            fn ($sequence) => ['user_app_status_id' => $Userappstatus_id[rand(0, $count_userappstatus - 1)]]
        ))
        ->create();

    }
}

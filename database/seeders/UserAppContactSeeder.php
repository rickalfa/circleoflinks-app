<?php

namespace Database\Seeders;

use App\Models\userAppContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAppContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        userAppContact::create([

            'user_id' => 1,
            'phone_number' => 9002234,
            'status' => "No-register"
        ]);



    }
}

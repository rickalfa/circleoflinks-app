<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\UserAppStatus;

class UserAppStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $status_names = array("email-no-verificed", "verificed", "sub-lv-1");



        UserAppStatus::factory()
        ->count(3)
        ->state(new Sequence(
          ['name' => $status_names[0] ],
          ['name' => $status_names[1] ],
          ['name' => $status_names[2] ]
        
        )
      )
      ->create();
    }
}

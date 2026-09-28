<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\Status_user;



class Status_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
      $status_names = array("free", "pro", "suspend", "reclutador", "active", "contanc");


      Status_user::factory()
      ->count(5)
      ->state(new Sequence(
        ['name' => $status_names[0] ],
        ['name' => $status_names[1] ],
        ['name' => $status_names[2] ],
        ['name' => $status_names[3] ],
        ['name' => $status_names[4] ]
      )
    )
    ->create();



    }
}

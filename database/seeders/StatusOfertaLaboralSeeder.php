<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\StatusOfertaLaboral;

class StatusOfertaLaboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        StatusOfertaLaboral::factory()
        ->count(3)
        ->create();



    }
}

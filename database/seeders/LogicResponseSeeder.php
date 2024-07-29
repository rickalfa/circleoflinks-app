<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\LogicResponse;


class LogicResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        LogicResponse::factory()
        ->count(4)
        ->state(new Sequence(
            fn ($sequence) => ['agent_id' => 1]
        ))
        ->create();


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(Status_userSeeder::class);

        $this->call(UserSeeder::class);

      
        $this->call(User_perfilSeeder::class);

        $this->call(EmpresaSeeder::class);



    }
}

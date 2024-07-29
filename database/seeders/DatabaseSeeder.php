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

        $this->call(UserOfertaLaboralSeeder::class);
        
      
        $this->call(User_perfilSeeder::class);

        $this->call(EmpresaSeeder::class);

        $this->call(StatusOfertaLaboralSeeder::class);

        $this->call(Oferta_laboralSeeder::class);
        
        /**
         * seeder user app web
         */

         $this->call(UserAppStatusSeeder::class);
         $this->call(UserAppSeeder::class);
         $this->call(UserAppContactSeeder::class);
         

         $this->call(AgentSeeder::class);


         $this->call(ConversationSeeder::class);
         $this->call(MessageSeeder::class);

         $this->call(LogicResponseSeeder::class);


    }
}

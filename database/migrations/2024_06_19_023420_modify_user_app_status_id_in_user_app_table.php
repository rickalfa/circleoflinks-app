<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        
    
     
            
            DB::statement("ALTER TABLE user_app MODIFY user_app_status_id BIGINT UNSIGNED DEFAULT 1");

        
       

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
   { 
          
             DB::statement("ALTER TABLE user_app MODIFY user_app_status_id BIGINT UNSIGNED DEFAULT NULL");
   
    
           
            
      
    }
};

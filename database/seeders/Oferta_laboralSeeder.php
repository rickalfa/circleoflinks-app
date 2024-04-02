<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\Empresa;
use App\Models\Oferta_laboral;
use App\Models\Status_oferta_laboral;

class Oferta_laboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Empresas_id = array();

        $EmpresasModel = Empresa::all();

        foreach ($EmpresasModel as $Empresa) {
            
            array_push($Empresas_id, $Empresa->id);

        }
       
        $count_empresas = count($Empresas_id);

/////// Obtenemos Registros del modelo Status_oferta_laboral
        $statusOfertaLaboral_id = array();

        $StatusOfertaLaboral = Status_oferta_laboral::all();

        foreach ($StatusOfertaLaboral as $StatusOL) {
            
            array_push($statusOfertaLaboral_id, $StatusOL->id);

        }


        $count_statusOL_id = count($statusOfertaLaboral_id);


       
        Oferta_laboral::factory()
        ->count($count_empresas)
        ->state(new Sequence(
            ['empresa_id' => $Empresas_id[rand(0, $count_empresas - 1)]],
        ))
        ->create();


    
    }
}

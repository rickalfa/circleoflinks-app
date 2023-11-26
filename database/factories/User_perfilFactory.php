<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

use App\Models\User_perfil;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class User_perfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $profeciones_names = array("analista", "abogado", "ingeniero civil", "ingeniero informatica",
                           "medico", "tecnico juridico", "tecnico redes");


       // $this->SembrarConRelacion();


        return [
            'info' => $this->faker->text(),
            'education' => $this->faker->name(),
            'exp_laboral' => $this->faker->text(),
            'habilidades' => $this->faker->text(),
            'profetion_name' => $profeciones_names[rand(0, 4)]
             
        ];
    }

    public function SembrarConRelacion(){

        $profeciones_names = array("analista", "abogado", "ingeniero civil", "ingeniero informatica",
        "medico", "tecnico juridico", "tecnico redes");

        
        $Users = User::all();

        foreach($Users as $User)
        {

            User_perfil::create(
                [
                    'info' => $this->faker->text(),
                    'education' => $this->faker->name(),
                    'exp_laboral' => $this->faker->text(),
                    'habilidades' => $this->faker->text(),
                    'profetion_name' => $profeciones_names[rand(0, 4)],
                    'user_id' => $User->id
                    
                ]
            );

        }



    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */



class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
 
        $rubro = array("tecnologia", "servicio-delivery", "construccion", "transporte");

      

        

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => "Street ".$this->faker->address(),
            'rubro' => $rubro[rand(0,3)],
            'user_id' => 2
        ];
    }
}

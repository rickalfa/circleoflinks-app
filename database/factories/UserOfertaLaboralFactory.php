<?php

namespace Database\Factories;

use App\Models\Oferta_laboral;
use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserOfertaLaboral>
 */
class UserOfertaLaboralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'description' => $this->faker->text
  
        ];
    }
}

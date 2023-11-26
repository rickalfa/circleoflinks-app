<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status_ofeta_laboral>
 */
class StatusOfetaLaboralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $status_names = array("cancel", "building", "finish", "public");





        return [
            
            'name' => $status_names[rand(0, 3)],
            'description' => $this->faker->text()


        ];
    }
}

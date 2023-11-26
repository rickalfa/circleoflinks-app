<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Status_userFactory extends Factory
{

    public $count = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $status_names = array("free", "pro", "suspend", "banned", "active");

        
        return [
            'name' => $status_names[0],
            'description' => $this->faker->text()

        ];
    }
}

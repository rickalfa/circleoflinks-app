<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\UserAppStatus>
 */
class UserAppStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $status_names = array("email-no-verificed", "verificed", "subcrito");



        return [
            
            'name'=>  $status_names[0],
            'description'=> $this->faker->text,


        ];
    }
}

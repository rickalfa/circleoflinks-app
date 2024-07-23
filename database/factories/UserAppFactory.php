<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserApp>
 */
class UserAppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => "Street ".$this->faker->address(),
            'avatar' => "imgs/avatar/avatar_profile_default.png",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            


        ];
    }



    private function generateRandomPhoneNumber()
{
    $faker = Faker::create();

    $phoneNumber = $faker->phoneNumber();

    // Remove special characters and spaces
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Ensure the phone number starts with a valid country code
    if (!preg_match('/^[1-9]\d{9}$/', $phoneNumber)) {
        $phoneNumber = $this->generateRandomPhoneNumber();
    }

    return $phoneNumber;
}
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'name' => $this->faker->name(). ' Logica de respuesta',
            'json_logic_response' => json_encode([
                [
                'id' => 0,
                'name_response_bot' => $this->faker->words(3),
                'key_trigger' => $this->faker->words(1),
                'response' => $this->faker->words(4),
                ],
                [
                    'id' => 1,
                    'name_response_bot' => $this->faker->words(1),
                    'key_trigger' => $this->faker->words(1),
                    'response' => $this->faker->words(3),
                ],
                [
                    'id' => 2,
                    'name_response_bot' => "agente_01",
                    'key_trigger' => "hola como estas",
                    'response' => "estoy aqui para servirle",
                ]]),
             'description' => " agente de prueba",
             'version' => $this->faker->numberBetween(1, 10)

        ];
    }
}

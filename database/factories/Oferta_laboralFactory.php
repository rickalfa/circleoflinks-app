<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oferta_laboral>
 */
class Oferta_laboralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $i = rand(1,100); 
        $salary_r = $i / rand(500, 10000); 



        return [
            //
            'title'=> $this->faker->title,
            'name'=>  $this->faker->name,
            'description'=> $this->faker->text,
            'date_expire'=> $this->faker->date,
            'status_oferta_laboral_id' => function (){
                return 2;
            },
            'salary'=> $salary_r

        ];
    }


    

}

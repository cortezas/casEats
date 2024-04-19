<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comida>
 */
class ComidaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "nombre" => fake()->name(),
            "dir" => fake()->address(),
            "email" => fake()->email(),
            "dni" => $this->dni()
        ];
    }

    private function dni(){
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $num = fake()->randomNumber(8,true);
        $num = $num >= 0 ? $num : -($num);
        $letra = $letras[$num%23];
        return "$num-$letra";
    }
}

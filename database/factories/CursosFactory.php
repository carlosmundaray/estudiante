<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cursos>
 */
class CursosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->jobTitle,
            'horario' => $this->faker->jobTitle,
            'fecha_inicio' => $this->faker->dateTime(),
            'fecha_fin' => $this->faker->dateTime('2024-02-25 08:37:17'),
        ];
    }
}

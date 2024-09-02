<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->numerify('########'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('1234'), // secret
            'remember_token' => \Str::random(10),
            'rol' => $this->faker->randomElement(['usuario' ,'expendedor','administrador']),
            'nombre' => $this->faker->name,
            'comentarios' => '',
            'es_cuenta_principal' => false,
        ];
    }
}
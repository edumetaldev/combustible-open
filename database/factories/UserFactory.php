<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'dni' => $faker->unique()->numerify('########'),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('1234'), // secret
        'remember_token' => str_random(10),
        'rol' => $faker->randomElement(['usuario' ,'expendedor','administrador']),
        'nombre' => $faker->name,
        'comentarios' => '',
        'es_cuenta_principal' => false,
    ];
});

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $estacion = App\Estacion::create([
          'nombre' => 'YPF',
          'empresa' => 'YPF'
        ]);

        $estacion = App\Estacion::create([
          'nombre' => 'SHELL',
          'empresa' => 'SHELL'
        ]);

        $estacion = App\Estacion::create([
          'nombre' => 'AXION',
          'empresa' => 'AXION'
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(CuentaCorrienteTableSeeder::class);
    }
}

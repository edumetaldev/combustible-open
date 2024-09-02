<?php

namespace Database\Seeders;

use App\Models\Estacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $estacion = Estacion::create([
          'nombre' => 'YPF',
          'empresa' => 'YPF'
        ]);

        $estacion = Estacion::create([
          'nombre' => 'SHELL',
          'empresa' => 'SHELL'
        ]);

        $estacion = Estacion::create([
          'nombre' => 'AXION',
          'empresa' => 'AXION'
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(CuentaCorrienteTableSeeder::class);
    }
}

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
        Estacion::create([
          'nombre' => 'YPF',
          'empresa' => 'YPF'
        ]);

        Estacion::create([
          'nombre' => 'SHELL',
          'empresa' => 'SHELL'
        ]);

        Estacion::create([
          'nombre' => 'AXION',
          'empresa' => 'AXION'
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(CuentaCorrienteTableSeeder::class);
    }
}

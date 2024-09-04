<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//administrador
		User::factory(1,[
			'dni' => '12345678',
			'email' => 'admin@combustibleMobile.deb',
			'password' => bcrypt('123456'),
			'remember_token' => \Str::random(40),
			'nombre' => 'Administrador',
			'rol' => 'Administrador',
			'es_cuenta_principal' => false,
			'cuenta_principal_id' => null,
		])->create();

		//expendedores
		User::factory(1,[
			'dni' => '99999999',
			'es_cuenta_principal' => false,
			'cuenta_principal_id' => null,
			'rol' => 'expendedor',
			'estacion_id' => 1,
			'password' => bcrypt('123456'),
			'remember_token' => \Str::random(40),
			'nombre' => 'Expendedor',
		])->create();

		User::factory(1,[
			'dni' => '88888888',
			'es_cuenta_principal' => false,
			'cuenta_principal_id' => null,
			'rol' => 'expendedor',
			'estacion_id' => 2,
			'password' => bcrypt('123456'),
			'remember_token' => \Str::random(40),
			'nombre' => 'Expendedor',
		])->create();

		User::factory(1,[
			'dni' => '77777777',
			'es_cuenta_principal' => false,
			'cuenta_principal_id' => null,
			'rol' => 'visor_cuentas',
			'estacion_id' => 3,
			'password' => bcrypt('123456'),
			'remember_token' => \Str::random(40),
			'nombre' => 'Visor Cuentas',
		])->create();

		// Crear 10 cuentas principales
		$cuentasPrincipales = User::factory(10,[
			'es_cuenta_principal' => true,
			'cuenta_principal_id' => null,
			'rol' => 'cuenta_principal'
		])->create();

		// Por cada cuenta principal, crear usuarios asociados
		$cuentasPrincipales->each(function ($u) {
			$rand = rand(3, 6);
			for ($i = 0; $i < $rand; $i++) {
				User::factory(1,[
					'cuenta_principal_id' => $u->id,
					'es_cuenta_principal' => false,
					'rol' => 'usuario'
				])->create();
			}
		});
	}
}

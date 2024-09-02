<?php

use Illuminate\Database\Seeder;

class CuentaCorrienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $estacion = DB::table('estaciones')->inRandomOrder()->first();

        $cuentas = App\User::where('es_cuenta_principal',true)->get();

// deposito inicial
        foreach ($cuentas as $cuenta) {
            App\CuentaCorriente::create([
              'usuario_id' => $cuenta->id,
              'linea' => 1,
              'usuario_id_destino' => null,
              'usuario_id_origen' => null,
              'estacion_id' => null,
              'comentarios' => 'Deposito Inicial',
              'tipo_movimiento' => 'deposito',
              'saldo' => 20000,
              'monto'=> 20000,
              'audi_usuario_id' => 1
            ]);
        }
                sleep(2);
// consumo
        $cuentas_principales = App\User::where('es_cuenta_principal',true)->get();

        foreach ($cuentas_principales as $cuenta) {

          $cuenta_saldo = DB::table('cuenta_corriente')->where('usuario_id',$cuenta->id)
              ->latest()
              ->value('saldo');

            App\CuentaCorriente::create([
              'usuario_id' => $cuenta->id,
              'linea' => 2,
              'usuario_id_destino' => null,
              'usuario_id_origen' => null,
              'estacion_id' => $estacion->id,
              'comentarios' => 'Consumo Estacion: '. $estacion->nombre,
              'tipo_movimiento' => 'consumo',
              'saldo' => $cuenta_saldo - 2000,
              'monto'=> -2000,
              'audi_usuario_id' => 1,
              'usuario_id_consumidor' =>  DB::table('usuarios')->where([['rol','usuario'],['cuenta_principal_id',$cuenta->id]])->inRandomOrder()->value('id')
            ]);
        }
sleep(2);
//
//transferencia
//
       $cuentas = App\User::where('es_cuenta_principal',true)->get();

        foreach ($cuentas as $cuenta) {

            // cuenta destino, cualquier otra principal
            $usuario_destino = DB::table('usuarios')->where([['es_cuenta_principal','=',true]])
                ->inRandomOrder()->first();

            $cuenta_destino = DB::table('cuenta_corriente')->where('usuario_id',$usuario_destino->id)
                    ->latest()
                    ->first();

            $cuenta_origen = DB::table('cuenta_corriente')->where('usuario_id',$cuenta->id)
                    ->latest()
                    ->first();
          // egreso
            App\CuentaCorriente::create([
              'usuario_id' => $cuenta_origen->usuario_id,
              'linea' =>  $cuenta_origen->linea + 1,
              'usuario_id_destino' => $cuenta_destino->usuario_id,
              'usuario_id_origen' => null,
              'estacion_id' => null,
              'comentarios' => 'Egreso por Transferencia a : '. $cuenta_destino->usuario_id,
              'tipo_movimiento' => 'transferencia',
              'saldo' => $cuenta_origen->saldo - 4000,
              'monto'=> -4000,
              'audi_usuario_id' => 1,
              'usuario_id_consumidor' =>  null
            ]);
          //ingreso
            App\CuentaCorriente::create([
              'usuario_id' => $cuenta_destino->usuario_id,
              'linea' => $cuenta_destino->linea + 1,
              'usuario_id_destino' => null,
              'usuario_id_origen' => $cuenta_origen->usuario_id,
              'estacion_id' => null,
              'comentarios' => 'Ingreso por Transferencia de : '. $cuenta_origen->usuario_id,
              'tipo_movimiento' => 'transferencia',
              'saldo' => $cuenta_destino->saldo + 4000,
              'monto'=> 4000,
              'audi_usuario_id' => 1,
              'usuario_id_consumidor' =>  null
            ]);
        }



    }
}

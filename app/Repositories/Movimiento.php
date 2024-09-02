<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 31/10/2018
 * Time: 16:39
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB as DB;
use App\CuentaCorriente;

class Movimiento
{
    public function ObtenerCuentaSaldo($usuario_id)
    {
        return DB::table('cuenta_corriente')
            ->where('usuario_id','=', $usuario_id )
            ->orderBy('id','desc')
            ->limit(1)
            ->first();
    }

    public function Transferir($cuenta_origen_id, $cuenta_destino_id, $monto,$comentarios)
    {

        DB::transaction(function () use ($cuenta_origen_id, $cuenta_destino_id,$monto,$comentarios ){

            $cuenta_origen = DB::table('cuenta_corriente')
                ->where('usuario_id','=', $cuenta_origen_id )
                ->orderBy('id','desc')
                ->limit(1)
                ->first();


            CuentaCorriente::Create([
                'usuario_id' => $cuenta_origen->usuario_id,
                'linea' => $cuenta_origen->linea + 1,
                'usuario_id_destino' => $cuenta_destino_id,
                'tipo_movimiento' => 'transferencia',
                'saldo' => $cuenta_origen->saldo - $monto,
                'monto' => abs($monto) * -1,
                'audi_usuario_id' => \Auth::id(),
                'comentarios' => $comentarios
            ]);

            $cuenta_destino = DB::table('cuenta_corriente')
                ->where('usuario_id','=', $cuenta_destino_id )
                ->orderBy('id','desc')
                ->limit(1)
                ->first();

            CuentaCorriente::Create([
                'usuario_id' => $cuenta_destino->usuario_id,
                'linea' => $cuenta_destino->linea + 1,
                'usuario_id_origen' => $cuenta_origen->usuario_id,
                'tipo_movimiento' => 'transferencia',
                'saldo' => $cuenta_destino->saldo + abs($monto),
                'monto' => abs($monto),
                'audi_usuario_id' => \Auth::id(),
                'comentarios' => $comentarios
            ]);
        });
    }

    public function Depositar($cuenta_destino_id, $monto, $comentarios)
    {
        DB::transaction(function () use ( $cuenta_destino_id, $monto, $comentarios ) {
            $cuenta_destino = $this->ObtenerCuentaSaldo($cuenta_destino_id);

            $saldo = isset($cuenta_destino->saldo) ? $cuenta_destino->saldo: 0;
            $linea = isset($cuenta_destino->linea) ? $cuenta_destino->linea + 1: 1;
            $monto = abs($monto);

            CuentaCorriente::Create([
                'usuario_id' => $cuenta_destino_id,
                'linea' => $linea,
                'tipo_movimiento' => 'deposito',
                'saldo' => $saldo + $monto,
                'monto' => $monto,
                'audi_usuario_id' => \Auth::id(),
                'comentarios' => $comentarios
            ]);
        });
    }

    public function Extraer($cuenta_usuario_id, $monto, $comentarios)
    {
        DB::transaction(function () use ( $cuenta_usuario_id, $monto, $comentarios ) {

            $cuenta= $this->ObtenerCuentaSaldo($cuenta_usuario_id);

            $saldo = isset($cuenta->saldo) ? $cuenta->saldo: 0;
            $monto = abs($monto);

            CuentaCorriente::Create([
                'usuario_id' => $cuenta_usuario_id,
                'linea' => $cuenta->linea + 1,
                'tipo_movimiento' => 'extraccion',
                'saldo' => $saldo - $monto,
                'monto' => $monto * -1,
                'audi_usuario_id' => \Auth::id(),
                'comentarios' => $comentarios
            ]);
        });
    }

    public function Consumir($cuenta_principal_id, $cuenta_consumidor_id,$monto,$estacion_id,$consumidor,$estacion)
    {
        DB::transaction(function () use ( $cuenta_principal_id, $cuenta_consumidor_id,$monto,$estacion_id,$consumidor,$estacion ){

            $cuenta = $this->ObtenerCuentaSaldo($cuenta_principal_id);

            CuentaCorriente::Create([
                'usuario_id' => $cuenta_principal_id,
                'linea' => $cuenta->linea + 1,
                'tipo_movimiento' => 'consumo',
                'saldo' => $cuenta->saldo - $monto,
                'monto' => $monto * -1,
                'audi_usuario_id' => \Auth::id(),
                'usuario_id_consumidor' => $cuenta_consumidor_id,
                'estacion_id' => $estacion_id,
                'comentarios' => 'Consumo Estacion: '. $estacion. ' por '. $consumidor
            ]);
        });

    }

    public function AnularConsumo($movimiento_id)
    {

        DB::transaction(function () use ($movimiento_id ){
            $movimiento =  CuentaCorriente::find($movimiento_id);

            $cuenta = $this->ObtenerCuentaSaldo($movimiento->usuario_id);

            $anulacion = CuentaCorriente::Create([
                'usuario_id' => $movimiento->usuario_id,
                'linea' => $cuenta->linea + 1,
                'tipo_movimiento' => 'anulacion',
                'saldo' => $cuenta->saldo + abs($movimiento->monto),
                'monto' => abs($movimiento->monto),
                'audi_usuario_id' => \Auth::id(),
                'usuario_id_consumidor' => $movimiento->usuario_id_consumidor,
                'estacion_id' => $movimiento->estacion_id,
                'comentarios' => 'ANULACIÓN::'. $movimiento->comentarios
            ]);

            $movimiento->update(['cuenta_id_anulacion' => $anulacion->id]);
            $movimiento->save();
        });
    }
}

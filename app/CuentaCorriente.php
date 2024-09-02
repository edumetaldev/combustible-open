<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaCorriente extends Model
{
    protected $table = 'cuenta_corriente';
    protected $fillable = [
        'usuario_id','linea','usuario_id_destino','usuario_id_origen',
        'estacion_id','tipo_movimiento','saldo','monto','audi_usuario_id',
        'comentarios','usuario_id_consumidor','cuenta_id_anulacion'
    ];


}

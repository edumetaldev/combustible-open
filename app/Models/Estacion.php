<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    protected $table = 'estaciones';

    protected $fillable = ['nombre','empresa','localidad','direccion'];
}

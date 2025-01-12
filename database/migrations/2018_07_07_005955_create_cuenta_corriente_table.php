<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaCorrienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_corriente', function (Blueprint $table) {

            $table->increments('id');
            $table->foreignId('usuario_id')->unsigned();
            $table->integer('linea')->unsigned()->default(1);
            $table->foreignId('usuario_id_destino')->nullable();
            $table->foreignId('usuario_id_origen')->nullable();
            $table->foreignId('estacion_id')->unsigned()->nullable();
            $table->text('comentarios')->nullable();
            $table->enum('tipo_movimiento',['transferencia','consumo','deposito','extraccion','anulacion'])->default('transferencia');
            $table->double('saldo', 8, 2)->default(0);
            $table->double('monto', 8, 2)->default(0);
            $table->foreignId('audi_usuario_id')->nullable();
            $table->foreignId('usuario_id_consumidor')->nullable();
            $table->timestamps();
            $table->foreignId('cuenta_id_anulacion')->nullable();

            $table->index('usuario_id');
            $table->index('usuario_id','linea');
        });

    }

    /**
     * Reverse the migrations.wdada
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta_corriente');
    }
}

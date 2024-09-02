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
            $table->integer('usuario_id')->unsigned();
            $table->integer('linea')->unsigned()->default(1);
            $table->integer('usuario_id_destino')->nulleable()->unsigned();
            $table->integer('usuario_id_origen')->nulleable()->unsigned();
            $table->integer('estacion_id')->unsigned()->nulleable();
            $table->string('comentarios',200)->default('');
            $table->enum('tipo_movimiento',['transferencia','consumo','deposito','extraccion']);
            $table->double('saldo', 8, 2)->default(0);
            $table->double('monto', 8, 2)->default(0);
            $table->integer('audi_usuario_id')->unsigned();
            $table->integer('usuario_id_consumidor')->unsigned();
            $table->timestamps();

            $table->index('usuario_id');
            $table->index('usuario_id','linea');

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('audi_usuario_id')->references('id')->on('usuarios');
            $table->foreign('estacion_id')->references('id')->on('estaciones');
            //$table->foreign('usuario_id_destino')->references('id')->on('usuarios');
            //$table->foreign('usuario_id_origen')->references('id')->on('usuarios');
        });

        DB::statement('ALTER TABLE `cuenta_corriente`
                    	CHANGE COLUMN `usuario_id_destino` `usuario_id_destino` INT(10) UNSIGNED NULL AFTER `linea`,
                    	CHANGE COLUMN `usuario_id_origen` `usuario_id_origen` INT(10) UNSIGNED NULL AFTER `usuario_id_destino`;');
        DB::statement('ALTER TABLE `cuenta_corriente`
	                    CHANGE COLUMN `estacion_id` `estacion_id` INT(10) UNSIGNED NULL AFTER `usuario_id_origen`;
                      ');
        DB::statement('ALTER TABLE `cuenta_corriente`
	                    CHANGE COLUMN `usuario_id_consumidor` `usuario_id_consumidor` INT(10) UNSIGNED NULL AFTER `estacion_id`;
                      ');
        DB::statement('ALTER TABLE `cuenta_corriente`
              	CHANGE COLUMN `comentarios` `comentarios` VARCHAR(200) NULL DEFAULT \'\' COLLATE \'utf8_unicode_ci\' AFTER `usuario_id_consumidor`
                ');
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

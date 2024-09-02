<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoMovimientoTablaCuentaCorriente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `cuenta_corriente`
	                    ALTER `tipo_movimiento` DROP DEFAULT;');
        DB::statement('ALTER TABLE `cuenta_corriente`
                      CHANGE COLUMN `tipo_movimiento` `tipo_movimiento` ENUM(\'transferencia\',\'consumo\',\'deposito\',\'extraccion\',\'anulacion\') NOT NULL COLLATE \'utf8_unicode_ci\' AFTER `comentarios`;
                      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

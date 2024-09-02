<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisorCuentasTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `usuarios`
                      ALTER `rol` DROP DEFAULT;');
        DB::statement('ALTER TABLE `usuarios`
                      CHANGE COLUMN `rol` `rol` ENUM(\'administrador\',\'usuario\',\'expendedor\',\'cuenta_principal\',\'cuenta_consumo\',\'visor_cuentas\') NOT NULL COLLATE \'utf8_unicode_ci\' AFTER `password`;
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

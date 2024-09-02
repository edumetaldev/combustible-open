<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOficinaTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('usuarios', function (Blueprint $table) {
          $table->string('oficina',200)->default('')->after('comentarios');
      });
      DB::statement('ALTER TABLE `usuarios`
                    CHANGE COLUMN `oficina` `oficina` VARCHAR(200) NULL DEFAULT \'\' COLLATE \'utf8_unicode_ci\' AFTER `comentarios`;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('usuarios', function (Blueprint $table) {
          $table->dropColumn('oficina');
      });
    }
}

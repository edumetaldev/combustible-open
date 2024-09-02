<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCuentaIdAnulacionTablaCuentaCorriente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuenta_corriente', function (Blueprint $table) {
            $table->unsignedInteger('cuenta_id_anulacion')->nullable();
            $table->foreign('cuenta_id_anulacion')->foreign('cuenta_id_anulacion')->references('id')->on('cuenta_corriente');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuenta_corriente', function (Blueprint $table) {
            $table->dropForeign('cuenta_corriente_cuenta_id_anulacion_foreign');
            $table->dropColumn('cuenta_id_anulacion');
        });
    }
}

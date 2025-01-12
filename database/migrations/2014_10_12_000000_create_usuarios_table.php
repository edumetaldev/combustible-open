<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->enum('rol',['administrador','usuario','expendedor','cuenta_principal']);
            $table->string('nombre',200);
            $table->string('comentarios',200)->nullable();
            $table->integer('cuenta_principal_id')->nullable()->unsigned();
            $table->boolean('es_cuenta_principal')->default(false);
            $table->foreignId('estacion_id')->default(null)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}

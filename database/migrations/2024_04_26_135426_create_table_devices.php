<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id();
            $table->string('dispositivo');
            $table->string('nombre_conexion');
            $table->string('estado');
            $table->string('tipo_grafico');
            $table->string('label_grafico');
            $table->string('min_grafico');
            $table->string('max_grafico');
            $table->integer('id_canal');
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
        Schema::dropIfExists('table_devices');
    }
};

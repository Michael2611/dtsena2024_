<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

     public function up()
     {
         Schema::create('surcos_plantas', function (Blueprint $table) {
             $table->id();
             $table->string('nomenclatura');
             $table->integer('num_surcos');
             $table->integer('num_plantas');
             $table->json('tabla');  // Para almacenar los surcos y plantas generados
             $table->timestamps();
         });
     }

     public function down()
     {
         Schema::dropIfExists('surcos_plantas');
     }

};

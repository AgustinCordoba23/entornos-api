<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios_vacantes', function (Blueprint $table) {
            $table->integer('usuario_id');
            $table->integer('vacante_id');
            $table->string('cv');
            $table->integer('orden_merito')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios_vacantes');
    }
};

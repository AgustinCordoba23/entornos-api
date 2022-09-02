<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id();
            $table->string('catedra');
            $table->string('descripcion');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacantes');
    }
};

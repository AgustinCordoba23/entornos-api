<?php

use App\Models\Rol;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        $acceso = Rol::where('id', 1)->first();
        $acceso->nombre = "Jefe de Cátedra";
        $acceso->save();

        $acceso = Rol::where('id', 2)->first();;
        $acceso->nombre = "Responsable Administrativo";
        $acceso->save();
    }

    public function down()
    {
        $acceso = Rol::getById(1);
        $acceso->nombre = "Admin";
        $acceso->guardar();

        $acceso = Rol::getById(2);
        $acceso->nombre = "Responsable";
        $acceso->guardar();
    }
};

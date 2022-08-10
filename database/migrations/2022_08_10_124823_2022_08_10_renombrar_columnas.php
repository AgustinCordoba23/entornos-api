<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('users', 'usuarios');
        Schema::table('usuarios', function(Blueprint $table) {
            $table->renameColumn('name', 'nombre');
        });
        Schema::table('usuarios', function($table) {
            $table->integer('rol');
        });
    }

    public function down()
    {
        Schema::rename('usuarios', 'users');
        Schema::table('users', function(Blueprint $table) {
            $table->renameColumn('nombre', 'name');
        });
        Schema::table('users', function($table) {
            $table->dropColumn('rol');
        });
    }
};

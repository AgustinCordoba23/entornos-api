<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['email_verified_at', 'remember_token']);

            $table->enum('estado', ['HABILITADO', 'DESHABILITADO']);
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('email_verified_at');
            $table->string('remember_token');

            $table->dropColumn(['estado']);
        });
    }
};

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UsuarioVacante extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    protected $table = "usuarios_vacantes";
}

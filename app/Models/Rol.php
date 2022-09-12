<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    const ROL_JEFE_CATEDRA = 1;
    const ROL_RESPONSABLE_ADMINISTRATIVO = 2;
    const ROL_USUARIO = 3;

    protected $guarded = [];
    public $timestamps = false;

    protected $table = "roles";
}

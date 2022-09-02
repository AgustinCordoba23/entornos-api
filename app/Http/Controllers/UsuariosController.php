<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\UsuarioResource;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    public function me() {
        $usuario = Auth::user();

        return new UsuarioResource($usuario);
    }
}

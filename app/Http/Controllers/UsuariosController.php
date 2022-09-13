<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
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

    public function listar(Request $request) {
        $filtros = $request->input('filtros', []);
        $usuarios = DB::table("usuarios");

        foreach ($filtros as $key => $value) {
            if (in_array($key, ['rol', 'estado'])) {
                $usuarios->where($key, '=', $value);
            } else {
                $usuarios->where($key, 'LIKE', '%'.$value.'%');
            }
        }

        $usuarios = $usuarios->get();

        return $usuarios;
    }

    public function getOne(int $usuarioId) {
        $usuarios = DB::table("usuarios");
        return $usuarios->where('id', '=', $usuarioId)->get();
    }

    public function habilitar(int $usuarioId) {
        $usuario = Usuario::where('id', $usuarioId)->first();
        $usuario->estado = 'HABILITADO';
        $usuario->save();

        return new UsuarioResource($usuario);
    }

    public function deshabilitar(int $usuarioId) {
        $usuario = Usuario::where('id', $usuarioId)->first();
        $usuario->estado = 'DESHABILITADO';
        $usuario->save();

        return new UsuarioResource($usuario);
    }
}

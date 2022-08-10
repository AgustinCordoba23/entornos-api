<?php

namespace App\Http\Controllers;

use App\Exceptions\UnprocessableEntityException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credenciales = $request->only('email', 'password');

        if (!Auth::attempt($credenciales)) {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        $usuario = Usuario::where('email', $credenciales['email'])->first();
        $token = $usuario->createToken('bearer-token')->plainTextToken;

        $usuario->load('rol_relacion');

        return response()->json([
            'usuario' => new UsuarioResource($usuario),
            'access_token' => $token
        ], 200);
    }

    public function registrar(RegistroRequest $request) {
        $campos = $request->only('email', 'password', 'nombre', 'rol');

        $usuario = Usuario::create([
            'nombre' => $campos['nombre'],
            'email' => $campos['email'],
            'rol' => $campos['rol'],
            'password' => bcrypt($campos['password'])
        ]);

        $token = $usuario->createToken('bearer-token')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'access_token' => $token
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([], 200);
    }

    public function me() {
        /** @var Usuario $user */
        $usuario = Auth::user();

        return new UsuarioResource($usuario);
    }


}


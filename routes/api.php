<?php

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VacantesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/vacantes', [VacantesController::class, 'listar']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    //Usuarios
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/eliminar-usuario', [AuthController::class, 'eliminar']);
    Route::get('/me', [AuthController::class, 'me']);

    //Vacantes
    Route::post('/vacantes', [VacantesController::class, 'crear']);
    Route::get('/vacantes/{id}', [VacantesController::class, 'getOne']);
    Route::patch('/vacantes/{id}', [VacantesController::class, 'modificar']);
});


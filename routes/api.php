<?php

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VacantesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/vacantes', [VacantesController::class, 'listar']);
Route::get('/vacantes/descargar-pdf/{nombre}', [VacantesController::class, 'descargarArchivo']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    //Auth
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/eliminar-usuario', [AuthController::class, 'eliminar']);
    Route::get('/me', [AuthController::class, 'me']);

    //Usuarios
    Route::get('/usuarios/listar', [UsuariosController::class, 'listar']);
    Route::get('/usuarios/{id}', [UsuariosController::class, 'getOne']);
    Route::post('/usuarios/{id}/habilitar', [UsuariosController::class, 'habilitar']);
    Route::post('/usuarios/{id}/deshabilitar', [UsuariosController::class, 'deshabilitar']);

    //Vacantes
    Route::post('/vacantes', [VacantesController::class, 'crear']);
    Route::get('/vacantes/mis-postulaciones', [VacantesController::class, 'misPostulaciones']);
    Route::get('/vacantes/{id}', [VacantesController::class, 'getOne']);
    Route::put('/vacantes/{id}', [VacantesController::class, 'modificar']);
    Route::delete('/vacantes/{id}', [VacantesController::class, 'eliminar']);
    Route::post('/vacantes/{id}/postularme', [VacantesController::class, 'postularme']);
    Route::post('/vacantes/{id}/cargar-resultados', [VacantesController::class, 'cargarResultados']);
});


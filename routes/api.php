<?php

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VacantesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::get('/users', [UsuariosController::class, 'get_users']);
*/

Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/vacantes', [VacantesController::class, 'listar']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/eliminar-usuario', [AuthController::class, 'eliminar']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/vacantes', [VacantesController::class, 'crear']);
});


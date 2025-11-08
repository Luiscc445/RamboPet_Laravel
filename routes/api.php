<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MascotaController;
use App\Http\Controllers\Api\V1\CitaController;
use App\Http\Controllers\Api\V1\EspecieController;
use App\Http\Controllers\Api\V1\RazaController;
use App\Http\Controllers\Api\V1\ProductoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la API REST para la aplicación móvil
| y la SPA pública. Todas están protegidas con Laravel Sanctum.
|
*/

// Rutas públicas de autenticación
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Rutas protegidas con Sanctum
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Recursos de la API
    Route::apiResource('mascotas', MascotaController::class);
    Route::apiResource('citas', CitaController::class);
    Route::apiResource('especies', EspecieController::class);
    Route::apiResource('razas', RazaController::class);
    Route::apiResource('productos', ProductoController::class);

    // Rutas personalizadas
    Route::get('/mascotas/{mascota}/historial', [MascotaController::class, 'historial']);
    Route::get('/citas/proximas', [CitaController::class, 'proximas']);
    Route::post('/citas/{cita}/confirmar', [CitaController::class, 'confirmar']);
    Route::post('/citas/{cita}/cancelar', [CitaController::class, 'cancelar']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']); 

Route::apiResource('categories', CategoryController::class);
Route::apiResource('tasks', TaskController::class);



// --- Rutas Protegidas ---
// Todas las rutas dentro de este grupo requerirán un token de Sanctum válido.
/* Route::middleware('auth:sanctum')->group(function () {

    // Ruta para obtener los datos del usuario actualmente autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rutas para las tareas (ahora seguras)
    Route::apiResource('tasks', TaskController::class);

    // Rutas para las categorías (si también quieres protegerlas)
    Route::apiResource('categories', CategoryController::class);

    // Aquí puedes añadir cualquier otra ruta que necesite autenticación,
    // por ejemplo, una ruta para hacer logout:
    // Route::post('/logout', [AuthController::class, 'logout']);

}); */
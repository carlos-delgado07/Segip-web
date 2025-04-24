<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\VerificarCIControllerApi;
use App\Http\Controllers\Api\FichaApiController;




Route::post('/comparar-imagenes', [VerificarCIControllerApi::class, 'compararImagen']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/ficha', [FichaApiController::class, 'generarFicha']);
    Route::get('/ficha', [FichaApiController::class, 'verFicha']);
});



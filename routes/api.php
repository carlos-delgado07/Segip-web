<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\VerificarCIControllerApi;
use App\Http\Controllers\Api\FichaApiController;
use App\Http\Controllers\Api\VerificarDocumentoJudicialControllerApi;
use App\Http\Controllers\Api\BrigadaSolicitudControllerApi;

Route::post('/comparar-imagenes', [VerificarCIControllerApi::class, 'compararImagen']);
Route::post('/verificar-documento-judicial', [VerificarDocumentoJudicialControllerApi::class, 'verificarDocumento']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Grupo de rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/brigada-solicitud', [BrigadaSolicitudControllerApi::class, 'store']);
    Route::post('/ficha', [FichaApiController::class, 'generarFicha']);
    Route::get('/ficha', [FichaApiController::class, 'verFicha']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

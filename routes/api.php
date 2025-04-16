<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificarCIController;

Route::post('/verificar', [VerificarCIController::class, 'compararImagen']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

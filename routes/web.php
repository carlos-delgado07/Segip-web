<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificarCIController;

// Ruta para mostrar el formulario de subir imagen
Route::get('/verificar', [VerificarCIController::class, 'showForm'])->name('imagen.form');

// Ruta para manejar la comparación de la imagen
Route::post('/verificar', [VerificarCIController::class, 'compararImagen'])->name('imagen.comparar');



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

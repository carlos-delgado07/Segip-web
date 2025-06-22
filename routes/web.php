<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificarCIController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\SolicitudBrigada;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Mostrar formulario para subir imágenes
Route::get('/verificar', [VerificarCIController::class, 'showForm'])->name('imagen.form');

// Enviar imágenes para comparar (comunicación con servidor Flask)
Route::post('/verificar', [VerificarCIController::class, 'compararImagen'])->name('imagen.comparar');

// Ver ficha por código (no requiere login, útil para mostrar en público o kiosko)
Route::get('/ficha/{codigo}', [FichaController::class, 'verFicha'])->name('ficha.ver');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Generar ficha (una vez verificado)
    Route::post('/generar-ficha', [FichaController::class, 'generarFicha'])->name('ficha.generar');
    Route::get('/ficha', [FichaController::class, 'mostrarFichaUsuario'])->name('ficha.mostrar');
    Route::get(('solicitud_brigada'),[SolicitudBrigada::class,'index'])->name('solicitud_brigada.index');
});

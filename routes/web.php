<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificarCIController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\SolicitudBrigada;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\SucursalController;
use App\Http\Controllers\FichaDepositoController;
use App\Http\Controllers\DocumentoJudicialWebController; //nuevo
use App\Http\Controllers\BrigadaSolicitudController;

// Página de bienvenida
Route::get('/', fn() => view('welcome'));

// Verificación de CI (sin autenticación)
Route::get('/verificar', [VerificarCIController::class, 'showForm'])->name('imagen.form');
Route::post('/verificar', [VerificarCIController::class, 'compararImagen'])->name('imagen.comparar');

// Ficha pública (por código, sin login)
Route::get('/ficha/ver/{codigo}', [FichaController::class, 'verFicha'])->name('ficha.ver');

// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Panel principal
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Ficha personal
    Route::post('/generar-ficha', [FichaController::class, 'generarFicha'])->name('ficha.generar');
    Route::get('/ficha', [FichaController::class, 'mostrarFichaUsuario'])->name('ficha.mostrar');
    Route::get('/nueva_ficha', [FichaController::class, 'nuevaFicha'])->name('nueva_ficha');

    // Solicitudes brigada
    Route::get('/solicitud_brigada', [SolicitudBrigada::class, 'index'])->name('solicitud_brigada.index');

    // Ficha con imagen de depósito
    Route::get('/ficha/solicitar', [FichaDepositoController::class, 'form'])->name('ficha.solicitar');
    Route::post('/ficha/solicitar', [FichaDepositoController::class, 'store'])->name('ficha.store');
    Route::get('/ficha/detalle/{codigo}', [FichaDepositoController::class, 'ver'])->name('ficha.detalle');

Route::get('/documento/formulario', [DocumentoJudicialWebController::class, 'formulario'])->name('documento.formulario');
Route::post('/documento/verificar', [DocumentoJudicialWebController::class, 'verificar'])->name('documento.verificar');

Route::get('/brigada/solicitar', [BrigadaSolicitudController::class, 'create'])->name('brigada.create');
Route::post('/brigada/solicitar', [BrigadaSolicitudController::class, 'store'])->name('brigada.store');

    // Administración
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('servicios', ServicioController::class);
        Route::resource('sucursales', SucursalController::class)->parameters([
            'sucursales' => 'sucursal'
        ]);
        Route::get('sucursales/{sucursal}/ventanillas', [SucursalController::class, 'ventanillas'])->name('sucursales.ventanillas');
        Route::post('sucursales/{sucursal}/ventanillas', [SucursalController::class, 'guardarVentanillas'])->name('sucursales.ventanillas.store');
    });
});

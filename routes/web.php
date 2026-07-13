<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeguridadesController;
use App\Http\Controllers\FacturaController;

/*
|--------------------------------------------------------------------------
| 1. PORTAL EXTERNO (Raíz /) - Manejado por Seguridades y Factura
|--------------------------------------------------------------------------
*/

// --- Rutas Públicas (Seguridades) ---
Route::get('/', function () {
    if (session()->has('user_external')) {
        return redirect('/dashboard');
    }
    return view('external.login');
})->name('login');

// Acciones de Login y Claves para Externos
Route::post('/login-external', [SeguridadesController::class, 'loginExternal']);
Route::get('/recuperar-clave', [SeguridadesController::class, 'showRecuperar']);
Route::post('/recuperar-clave', [SeguridadesController::class, 'sendRecuperar']); // Acción de enviar correo/API
Route::get('/configurar-clave', [SeguridadesController::class, 'showActualizarAfterLogin']);
Route::get('/actualizar-clave', [SeguridadesController::class, 'showActualizar']);
Route::post('/actualizar-clave', [SeguridadesController::class, 'updateClave']);

Route::get('/documentos', [FacturaController::class, 'showDocumentos']);

// --- Rutas Protegidas (Factura) ---
Route::middleware(['auth.external'])->group(function () {
    Route::get('/dashboard', [FacturaController::class, 'externalDashboard']);
    Route::post('/logout-external', [SeguridadesController::class, 'logoutExternal']);
    
    // Aquí irían más rutas de facturas para externos si fueran necesarias, ej:
    // Route::get('/facturas/ver/{id}', [FacturaController::class, 'showExternal']);
});


/*
|--------------------------------------------------------------------------
| 2. PORTAL EMPRESARIAL (/empresarial) - Manejado por Seguridades y Factura
|--------------------------------------------------------------------------
*/

// --- Ruta Pública (Seguridades) ---
Route::get('/empresarial', function () {
    if (session()->has('user_veris')) {
        return redirect('/empresarial/dashboard');
    }
    return view('veris.login');
});

// Acción de Login para Personal de la Empresa
Route::post('/empresarial/login', [SeguridadesController::class, 'loginVeris']);

// --- Rutas Protegidas (Factura) ---
Route::middleware(['auth.veris'])->group(function () {
    Route::get('/empresarial/dashboard', [FacturaController::class, 'verisDashboard']);
    Route::post('/empresarial/logout', [SeguridadesController::class, 'logoutVeris']);
    
    // Aquí irían más rutas de gestión de facturas internas, ej:
    // Route::get('/empresarial/facturas', [FacturaController::class, 'index']);
});
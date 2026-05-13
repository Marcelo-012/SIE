<?php

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\personas\Docente;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth:alumno'])->group(function () {
    Route::get('/alumno/dashboard', fn () => view('alumnos.dashboard'))
        ->name('alumno.dashboard');
});

Route::middleware(['auth:docente'])->group(function () {

    // ── Dashboard ────────────────────────────────────────────────
   Route::get('/docente/dashboard', function () {
    $docente = \App\Models\personas\Docente::find(auth('docente')->id());
    return view('docentes.dashboard', [
        'docente' => $docente,
        'usuario' => $docente,
    ]);
})->name('docente.dashboard');

    // ── Completar perfil ─────────────────────────────────────────
    Route::get('/completar-perfil',  [DocenteController::class, 'mostrarCompletarPerfil'])
        ->name('docentes.completar-perfil');
    Route::post('/completar-perfil', [DocenteController::class, 'completarPerfil']);

    // ── Perfil personal ──────────────────────────────────────────
    Route::get('/docente/perfil', [DocenteController::class, 'show'])
        ->name('docentes.perfil');

    Route::patch('/docente/perfil/actualizar', [DocenteController::class, 'actualizar'])
        ->name('docentes.perfil.actualizar');

    // ── Cambiar contraseña ───────────────────────────────────────
    Route::get('/docente/cambiar-contrasena',  [DocenteController::class, 'mostrarCambiarContrasena'])
        ->name('docentes.cambiar-contrasena');
    Route::post('/docente/cambiar-contrasena', [DocenteController::class, 'cambiarContrasena'])
        ->name('docentes.cambiar-contrasena.guardar');

    // ── Cerrar sesión ────────────────────────────────────────────
    Route::post('/docente/logout', function () {
        auth('docente')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('docente.logout');

});

require __DIR__ . '/auth.php';
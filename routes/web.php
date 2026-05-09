<?php

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth:alumno'])->group(function () {
    Route::get('/alumno/dashboard', fn () => view('alumnos.dashboard'))
        ->name('alumno.dashboard');
});

Route::middleware(['auth:docente'])->group(function () {
    Route::get('/docente/dashboard', fn () => view('docentes.dashboard'))
        ->name('docente.dashboard');

    Route::get('/completar-perfil', [DocenteController::class, 'mostrarCompletarPerfil'])
        ->name('docentes.completar-perfil');
    Route::post('/completar-perfil', [DocenteController::class, 'completarPerfil']);
});

require __DIR__ . '/auth.php';

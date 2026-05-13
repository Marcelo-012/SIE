<?php

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ProgramaController;
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

    // ── Módulo Grupos ────────────────────────────────────────────
    Route::get('/docente/grupos/ciclos',                     [GrupoController::class, 'ciclos'])->name('docente.grupos.ciclos');
    Route::get('/docente/grupos/datos',                      [GrupoController::class, 'datos'])->name('docente.grupos.datos');
    Route::get('/docente/grupos/{id_grupo}/calificar',       [GrupoController::class, 'calificar'])->name('docente.grupos.calificar');
    Route::post('/docente/grupos/calificacion',              [GrupoController::class, 'guardarCalificacion'])->name('docente.grupos.guardar-cal');
    Route::post('/docente/grupos/desercion',                 [GrupoController::class, 'guardarDesercion'])->name('docente.grupos.desercion');
    Route::get('/docente/grupos/{id_grupo}/reporte/inicio',  [GrupoController::class, 'reporteInicio'])->name('docente.grupos.reporte.inicio');
    Route::get('/docente/grupos/{id_grupo}/reporte/intermedio', [GrupoController::class, 'reporteIntermedio'])->name('docente.grupos.reporte.intermedio');
    Route::get('/docente/grupos/{id_grupo}/reporte/fin',     [GrupoController::class, 'reporteFin'])->name('docente.grupos.reporte.fin');

    // ── Módulo Programa ──────────────────────────────────────────
    Route::get('/docente/grupos/{id_grupo}/programa/datos',              [ProgramaController::class, 'datos'])->name('docente.programa.datos');
    Route::post('/docente/grupos/{id_grupo}/programa/bibliografia',      [ProgramaController::class, 'guardarBibliografia'])->name('docente.programa.bibliografia');
    Route::post('/docente/grupos/{id_grupo}/programa/tareas',            [ProgramaController::class, 'crearTarea'])->name('docente.programa.tareas.crear');
    Route::delete('/docente/grupos/{id_grupo}/programa/tareas/{id_tarea}', [ProgramaController::class, 'eliminarTarea'])->name('docente.programa.tareas.eliminar');
    Route::get('/docente/grupos/{id_grupo}/programa/estudiantes/descargar', [ProgramaController::class, 'descargarEstudiantes'])->name('docente.programa.estudiantes.descargar');

    // ── Cerrar sesión ────────────────────────────────────────────
    Route::post('/docente/logout', function () {
        auth('docente')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('docente.logout');

});

require __DIR__ . '/auth.php';
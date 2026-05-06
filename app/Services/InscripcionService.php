<?php

namespace App\Services;

use App\Models\Inscripcion;
use App\Models\Grupo;
use App\Models\Alumno;

class InscripcionService
{
    /**
     * Inscribe un alumno en un grupo.
     *
     * @param Alumno $alumno
     * @param Grupo $grupo
     * @return Inscripcion
     * @throws \Exception
     */
    public function inscribirAlumno(Alumno $alumno, Grupo $grupo): Inscripcion
    {
        // Validar cupo
        if ($grupo->inscripciones()->count() >= $grupo->cupo_max) {
            throw new \Exception('El grupo ya está lleno');
        }

        // Validar que no esté inscrito
        if ($alumno->inscripciones()->where('id_grupo', $grupo->id_grupo)->exists()) {
            throw new \Exception('El alumno ya está inscrito en este grupo');
        }

        // Crear inscripción
        return Inscripcion::create([
            'id_alumno' => $alumno->id_alumno,
            'id_grupo' => $grupo->id_grupo,
            'estatus' => 'cursando'
        ]);
    }
}

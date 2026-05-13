<?php

namespace Database\Seeders;

use App\Models\CicloEscolar;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Materia;
use App\Models\personas\Alumno;
use App\Models\personas\Docente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GruposSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Ciclos escolares ──────────────────────────────────────
        $ciclos = [
            ['nombre_ciclo_escolar' => 'Enero - Junio / 2026',    'fecha_inicio' => '2026-01-12', 'fecha_fin' => '2026-06-30'],
            ['nombre_ciclo_escolar' => 'Agosto - Diciembre / 2025','fecha_inicio' => '2025-08-11', 'fecha_fin' => '2025-12-19'],
            ['nombre_ciclo_escolar' => 'Enero - Junio / 2025',    'fecha_inicio' => '2025-01-13', 'fecha_fin' => '2025-06-27'],
            ['nombre_ciclo_escolar' => 'Agosto - Diciembre / 2024','fecha_inicio' => '2024-08-12', 'fecha_fin' => '2024-12-20'],
            ['nombre_ciclo_escolar' => 'Enero - Junio / 2024',    'fecha_inicio' => '2024-01-15', 'fecha_fin' => '2024-06-28'],
        ];

        foreach ($ciclos as $c) {
            CicloEscolar::updateOrCreate(
                ['nombre_ciclo_escolar' => $c['nombre_ciclo_escolar']],
                $c
            );
        }

        $cicloActual = CicloEscolar::where('nombre_ciclo_escolar', 'Enero - Junio / 2026')->first();

        // ── 2. Materias ──────────────────────────────────────────────
        $materias = [
            [
                'clave_materia'  => 'ACA-0910',
                'nombre_materia' => 'Taller De Investigación II',
                'unidades'       => 3,
                'creditos'       => 4,
                'plan_estudios'  => 'Ingeniería en Sistemas Computacionales',
                'departamento'   => 'Departamento de Sistemas y Computación',
                'idioma'         => 'Español',
            ],
            [
                'clave_materia'  => 'SCC-1016',
                'nombre_materia' => 'Fundamentos de Bases de Datos',
                'unidades'       => 4,
                'creditos'       => 5,
                'plan_estudios'  => 'Ingeniería en Sistemas Computacionales',
                'departamento'   => 'Departamento de Sistemas y Computación',
                'idioma'         => 'Español',
            ],
            [
                'clave_materia'  => 'SCD-1027',
                'nombre_materia' => 'Programación Web',
                'unidades'       => 3,
                'creditos'       => 4,
                'plan_estudios'  => 'Ingeniería en Sistemas Computacionales',
                'departamento'   => 'Departamento de Sistemas y Computación',
                'idioma'         => 'Español',
            ],
        ];

        foreach ($materias as $m) {
            Materia::updateOrCreate(
                ['clave_materia' => $m['clave_materia']],
                $m
            );
        }

        $materiaPrincipal = Materia::where('clave_materia', 'ACA-0910')->first();
        $materiaBD        = Materia::where('clave_materia', 'SCC-1016')->first();

        // ── 3. Docente ───────────────────────────────────────────────
        $docente = Docente::where('usuario', 'edgar.garcia')->first();

        if (!$docente) {
            $this->command->warn('Docente edgar.garcia no existe. Ejecuta primero UserSeeder.');
            return;
        }

        // ── 4. Grupos ────────────────────────────────────────────────
        $grupoG1 = Grupo::updateOrCreate(
            [
                'id_materia'       => $materiaPrincipal->id_materia,
                'id_ciclo_escolar' => $cicloActual->id_ciclo_escolar,
                'letra'            => 'A',
            ],
            [
                'id_docente' => $docente->id_docente,
                'salon'      => 'G1',
                'cupo'       => 0,
                'cupo_max'   => 35,
                'activo'     => true,
            ]
        );

        $grupoBD = Grupo::updateOrCreate(
            [
                'id_materia'       => $materiaBD->id_materia,
                'id_ciclo_escolar' => $cicloActual->id_ciclo_escolar,
                'letra'            => 'B',
            ],
            [
                'id_docente' => $docente->id_docente,
                'salon'      => 'B3',
                'cupo'       => 0,
                'cupo_max'   => 30,
                'activo'     => true,
            ]
        );

        // ── 5. Horarios ──────────────────────────────────────────────
        $horariosG1 = [
            ['dia_semana' => 'lunes',    'hora_inicio' => '16:00:00', 'hora_final' => '18:00:00', 'salon' => 'G1'],
            ['dia_semana' => 'jueves',   'hora_inicio' => '16:00:00', 'hora_final' => '18:00:00', 'salon' => 'G1'],
        ];

        foreach ($horariosG1 as $h) {
            Horario::updateOrCreate(
                ['id_grupo' => $grupoG1->id_grupo, 'dia_semana' => $h['dia_semana'], 'hora_inicio' => $h['hora_inicio']],
                ['hora_final' => $h['hora_final'], 'salon' => $h['salon']]
            );
        }

        $horariosBD = [
            ['dia_semana' => 'martes',   'hora_inicio' => '07:00:00', 'hora_final' => '09:00:00', 'salon' => 'Lab-3'],
            ['dia_semana' => 'miercoles','hora_inicio' => '07:00:00', 'hora_final' => '09:00:00', 'salon' => 'Lab-3'],
            ['dia_semana' => 'viernes',  'hora_inicio' => '07:00:00', 'hora_final' => '09:00:00', 'salon' => 'Lab-3'],
        ];

        foreach ($horariosBD as $h) {
            Horario::updateOrCreate(
                ['id_grupo' => $grupoBD->id_grupo, 'dia_semana' => $h['dia_semana'], 'hora_inicio' => $h['hora_inicio']],
                ['hora_final' => $h['hora_final'], 'salon' => $h['salon']]
            );
        }

        // ── 6. Alumnos ───────────────────────────────────────────────
        $alumnosData = [
            ['matricula' => '24730279', 'nombre' => 'Alicia Jazmín',   'apellido_pat' => 'Calderón',  'apellido_mat' => 'Gutiérrez'],
            ['matricula' => '24730003', 'nombre' => 'Fela Manuel',     'apellido_pat' => 'Calderón',  'apellido_mat' => 'Gutiérrez'],
            ['matricula' => '24730298', 'nombre' => 'Sabas Kadaly',    'apellido_pat' => 'Calderón',  'apellido_mat' => 'Salinas'],
            ['matricula' => '22730126', 'nombre' => 'José Carlos',     'apellido_pat' => 'Camacho',   'apellido_mat' => 'Cruz'],
            ['matricula' => '22730308', 'nombre' => 'Ingrid',          'apellido_pat' => 'Carrero',   'apellido_mat' => 'Lezama'],
            ['matricula' => '22730134', 'nombre' => 'Mauricio Jabel',  'apellido_pat' => 'Cano',      'apellido_mat' => 'Hernández'],
            ['matricula' => '22730311', 'nombre' => 'Melissa Abigail', 'apellido_pat' => 'Castañeda', 'apellido_mat' => 'Rodríguez'],
            ['matricula' => '22730112', 'nombre' => 'Kristianna',      'apellido_pat' => 'Galán',     'apellido_mat' => 'Lugo'],
            ['matricula' => '22730142', 'nombre' => 'Alejandro Javier','apellido_pat' => 'Gallegos',  'apellido_mat' => 'Garza'],
            ['matricula' => '22730132', 'nombre' => 'Rubí',            'apellido_pat' => 'García',    'apellido_mat' => 'Aparicio'],
            ['matricula' => '22730200', 'nombre' => 'Luis Alberto',    'apellido_pat' => 'Hernández', 'apellido_mat' => 'López'],
            ['matricula' => '22730201', 'nombre' => 'María Fernanda',  'apellido_pat' => 'Jiménez',   'apellido_mat' => 'Torres'],
        ];

        // Deduplicar por matrícula
        $alumnosPorMatricula = collect($alumnosData)->unique('matricula')->values();

        $alumnosCreados = [];
        foreach ($alumnosPorMatricula as $a) {
            Alumno::updateOrCreate(
                ['matricula' => $a['matricula']],
                [
                    'nombre'          => $a['nombre'],
                    'apellido_pat'    => $a['apellido_pat'],
                    'apellido_mat'    => $a['apellido_mat'],
                    'password'        => Hash::make('password123'),
                    'fecha_nacimiento'=> '2004-01-01',
                    'curp'            => 'XXXX000000XXXXXX0' . substr($a['matricula'], -2),
                    'genero'          => 'masculino',
                    'estado_civil'    => 'soltero',
                    'calle_y_numero'  => 'Calle Principal 1',
                    'colonia'         => 'Centro',
                    'municipio'       => 'Pinotepa Nacional',
                    'estado'          => 'Oaxaca',
                    'codigo_postal'   => '71600',
                    'telefono'        => '9540000000',
                    'correo'          => strtolower($a['apellido_pat']) . $a['matricula'] . '@itpinotepa.edu.mx',
                    'carrera'         => 'Ingenieria en Sistemas Computacionales',
                    'especialidad'    => 'Sin especialidad',
                    'status'          => 'activo',
                ]
            );
            // Recargar desde BD para obtener id_alumno (autoincrement no se captura
            // automáticamente cuando $incrementing = false en el modelo)
            $alumnosCreados[] = Alumno::where('matricula', $a['matricula'])->first();
        }

        // ── 7. Inscripciones ─────────────────────────────────────────
        // Todos los alumnos al grupo G1, los primeros 5 también a BD
        foreach ($alumnosCreados as $idx => $alumno) {
            $ins = Inscripcion::updateOrCreate(
                ['id_alumno' => $alumno->id_alumno, 'id_grupo' => $grupoG1->id_grupo],
                ['intento' => 1, 'estatus' => 'cursando']
            );

            // Calificaciones de ejemplo para algunos alumnos
            if ($idx < 6) {
                $diagnostica = rand(70, 100);
                $reporte     = rand(65, 98);
                $u1 = rand(68, 100);
                $u2 = rand(65, 100);
                // Unidad 3 aún sin calificar para algunos

                $cal = Calificacion::updateOrCreate(
                    ['id_inscripcion' => $ins->id_inscripcion, 'unidad' => 1],
                    [
                        'calificacion'           => $u1,
                        'fecha'                  => now(),
                        'cal_diagnostica'        => $diagnostica,
                        'cal_reporte_intermedio' => $reporte,
                        'califiacion_final'      => null,
                    ]
                );

                Calificacion::updateOrCreate(
                    ['id_inscripcion' => $ins->id_inscripcion, 'unidad' => 2],
                    ['calificacion' => $u2, 'fecha' => now()]
                );
            }
        }

        // Actualizar cupos
        $grupoG1->cupo = count($alumnosCreados);
        $grupoG1->save();

        // Primeros 5 alumnos también en el grupo de BD
        foreach (array_slice($alumnosCreados, 0, 5) as $alumno) {
            Inscripcion::updateOrCreate(
                ['id_alumno' => $alumno->id_alumno, 'id_grupo' => $grupoBD->id_grupo],
                ['intento' => 1, 'estatus' => 'cursando']
            );
        }
        $grupoBD->cupo = 5;
        $grupoBD->save();

        $this->command->info('GruposSeeder ejecutado correctamente.');
        $this->command->info("  Ciclos:        " . CicloEscolar::count());
        $this->command->info("  Materias:      " . Materia::count());
        $this->command->info("  Grupos:        " . Grupo::count());
        $this->command->info("  Alumnos:       " . count($alumnosCreados));
        $this->command->info("  Inscripciones: " . Inscripcion::count());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CicloEscolar;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GrupoController extends Controller
{
    // ── Ciclos disponibles ───────────────────────────────────────────
    public function ciclos()
    {
        $ciclos = CicloEscolar::orderByDesc('fecha_inicio')
            ->get(['id_ciclo_escolar', 'nombre_ciclo_escolar']);

        return response()->json([
            'ciclos'      => $ciclos,
            'cicloActual' => $this->cicloActualId(),
        ]);
    }

    // ── Datos del panel grupos (materias + horarios) ─────────────────
    public function datos(Request $request)
    {
        $cicloId = $request->integer('ciclo') ?: $this->cicloActualId();
        $docente = auth('docente')->user();

        $grupos = Grupo::where('id_docente', $docente->id_docente)
            ->where('id_ciclo_escolar', $cicloId)
            ->with([
                'materia',
                'horarios' => fn ($q) => $q->orderByRaw("FIELD(dia_semana,'lunes','martes','miercoles','jueves','viernes')")->orderBy('hora_inicio'),
                'cicloEscolar',
            ])
            ->get();

        return response()->json([
            'grupos' => $grupos->map(fn ($g) => [
                'id_grupo' => $g->id_grupo,
                'letra'    => $g->letra,
                'salon'    => $g->salon,
                'cupo'     => $g->cupo,
                'cupo_max' => $g->cupo_max,
                'materia'  => $g->materia,
                'horarios' => $g->horarios,
                'ciclo'    => $g->cicloEscolar?->nombre_ciclo_escolar,
            ]),
        ]);
    }

    // ── Datos de calificaciones para un grupo ────────────────────────
    public function calificar(int $id_grupo)
    {
        $docente = auth('docente')->user();

        $grupo = Grupo::where('id_grupo', $id_grupo)
            ->where('id_docente', $docente->id_docente)
            ->with('materia')
            ->firstOrFail();

        $inscripciones = Inscripcion::where('id_grupo', $id_grupo)
            ->with(['alumno', 'calificaciones'])
            ->orderBy('id_inscripcion')
            ->get();

        $unidades = $grupo->materia->unidades ?? 3;

        $data = $inscripciones->map(function ($ins) use ($unidades) {
            $cals = $ins->calificaciones;
            $meta = $cals->first();

            $porUnidad = [];
            for ($u = 1; $u <= $unidades; $u++) {
                $cal = $cals->firstWhere('unidad', $u);
                $porUnidad[$u] = $cal?->calificacion;
            }

            return [
                'id_inscripcion'         => $ins->id_inscripcion,
                'intento'                => $ins->intento,
                'estatus'                => $ins->estatus,
                'matricula'              => $ins->alumno->matricula ?? $ins->id_alumno,
                'nombre_alumno'          => $ins->alumno
                    ? trim("{$ins->alumno->nombre} {$ins->alumno->apellido_pat} {$ins->alumno->apellido_mat}")
                    : 'Sin nombre',
                'cal_diagnostica'        => $meta?->cal_diagnostica,
                'cal_reporte_intermedio' => $meta?->cal_reporte_intermedio,
                'calificacion_final'     => $meta?->califiacion_final,
                'desercion'              => $ins->estatus === 'reprobado',
                'unidades'               => $porUnidad,
            ];
        });

        return response()->json([
            'grupo'         => [
                'id_grupo' => $grupo->id_grupo,
                'letra'    => $grupo->letra,
                'materia'  => $grupo->materia,
                'unidades' => $unidades,
            ],
            'inscripciones' => $data,
        ]);
    }

    // ── Guardar calificación (unidad, diagnóstica, reporte, final) ───
    public function guardarCalificacion(Request $request)
    {
        $request->validate([
            'id_inscripcion' => 'required|integer|exists:inscripciones,id_inscripcion',
            'tipo'           => 'required|string',
            'valor'          => 'nullable|integer|min:0|max:100',
        ]);

        $inscripcion = Inscripcion::findOrFail($request->id_inscripcion);
        $this->verificarPropiedadGrupo($inscripcion->id_grupo);

        $tipo  = $request->tipo;
        $valor = $request->valor;

        if (in_array($tipo, ['diagnostica', 'reporte', 'final'])) {
            $cal = Calificacion::firstOrNew([
                'id_inscripcion' => $inscripcion->id_inscripcion,
                'unidad'         => 1,
            ]);
            if (!$cal->exists) {
                $cal->calificacion = null;
                $cal->fecha = now();
            }
            match ($tipo) {
                'diagnostica' => $cal->cal_diagnostica = $valor,
                'reporte'     => $cal->cal_reporte_intermedio = $valor,
                'final'       => $cal->califiacion_final = $valor,
            };
            $cal->save();
        } elseif (is_numeric($tipo)) {
            Calificacion::updateOrCreate(
                ['id_inscripcion' => $inscripcion->id_inscripcion, 'unidad' => (int) $tipo],
                ['calificacion' => $valor, 'fecha' => now()]
            );
        }

        return response()->json(['ok' => true]);
    }

    // ── Guardar deserción ────────────────────────────────────────────
    public function guardarDesercion(Request $request)
    {
        $request->validate([
            'id_inscripcion' => 'required|integer|exists:inscripciones,id_inscripcion',
            'desercion'      => 'required|boolean',
        ]);

        $inscripcion = Inscripcion::findOrFail($request->id_inscripcion);
        $this->verificarPropiedadGrupo($inscripcion->id_grupo);

        $inscripcion->estatus = $request->boolean('desercion') ? 'reprobado' : 'cursando';
        $inscripcion->save();

        return response()->json(['ok' => true]);
    }

    // ── Reporte: Inicio de curso ─────────────────────────────────────
    public function reporteInicio(int $id_grupo)
    {
        return view('docentes.reportes.inicio-curso', $this->datosReporte($id_grupo));
    }

    // ── Reporte: Intermedio ──────────────────────────────────────────
    public function reporteIntermedio(int $id_grupo)
    {
        return view('docentes.reportes.intermedio', $this->datosReporte($id_grupo));
    }

    // ── Reporte: Fin de curso ────────────────────────────────────────
    public function reporteFin(int $id_grupo)
    {
        return view('docentes.reportes.fin-curso', $this->datosReporte($id_grupo));
    }

    // ── Helpers privados ─────────────────────────────────────────────
    private function cicloActualId(): ?int
    {
        $hoy = Carbon::today();
        $ciclo = CicloEscolar::where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();

        return $ciclo?->id_ciclo_escolar
            ?? CicloEscolar::orderByDesc('fecha_inicio')->value('id_ciclo_escolar');
    }

    private function verificarPropiedadGrupo(int $idGrupo): void
    {
        $docente = auth('docente')->user();
        abort_unless(
            Grupo::where('id_grupo', $idGrupo)
                ->where('id_docente', $docente->id_docente)
                ->exists(),
            403
        );
    }

    private function datosReporte(int $id_grupo): array
    {
        $docente = auth('docente')->user();

        $grupo = Grupo::where('id_grupo', $id_grupo)
            ->where('id_docente', $docente->id_docente)
            ->with(['materia', 'cicloEscolar'])
            ->firstOrFail();

        $inscripciones = Inscripcion::where('id_grupo', $id_grupo)
            ->with(['alumno', 'calificaciones'])
            ->orderBy('id_inscripcion')
            ->get();

        $unidades = $grupo->materia->unidades ?? 3;

        return compact('grupo', 'docente', 'inscripciones', 'unidades');
    }
}

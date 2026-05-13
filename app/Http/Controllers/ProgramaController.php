<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Tarea;
use App\Models\UnidadTemario;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function datos(int $id_grupo)
    {
        $docente = auth('docente')->user();

        $grupo = Grupo::where('id_grupo', $id_grupo)
            ->where('id_docente', $docente->id_docente)
            ->with(['materia', 'cicloEscolar'])
            ->firstOrFail();

        $materia  = $grupo->materia;
        $unidades = $materia->unidades ?? 3;

        $estudiantes = Inscripcion::where('id_grupo', $id_grupo)
            ->with('alumno')
            ->orderBy('id_inscripcion')
            ->get()
            ->map(fn ($ins) => [
                'matricula' => $ins->alumno->matricula ?? '—',
                'nombre'    => $ins->alumno
                    ? trim("{$ins->alumno->nombre} {$ins->alumno->apellido_pat} {$ins->alumno->apellido_mat}")
                    : 'Sin nombre',
            ]);

        $temario = UnidadTemario::where('id_materia', $materia->id_materia)
            ->orderBy('numero')
            ->get(['id_unidad', 'numero', 'titulo', 'descripcion']);

        $tareasPorUnidad = [];
        $tareasDB = Tarea::where('id_grupo', $id_grupo)->orderBy('created_at')->get();
        for ($u = 1; $u <= $unidades; $u++) {
            $tareasPorUnidad[$u] = $tareasDB
                ->where('numero_unidad', $u)
                ->values()
                ->map(fn ($t) => [
                    'id_tarea'    => $t->id_tarea,
                    'titulo'      => $t->titulo,
                    'descripcion' => $t->descripcion,
                    'fecha_entrega' => $t->fecha_entrega?->format('Y-m-d'),
                ])
                ->all();
        }

        return response()->json([
            'grupo' => [
                'id_grupo' => $grupo->id_grupo,
                'letra'    => $grupo->letra,
                'unidades' => $unidades,
                'materia'  => [
                    'id_materia'    => $materia->id_materia,
                    'clave_materia' => $materia->clave_materia,
                    'nombre_materia' => $materia->nombre_materia,
                    'plan_estudios' => $materia->plan_estudios,
                    'departamento'  => $materia->departamento,
                    'unidades'      => $materia->unidades,
                ],
            ],
            'estudiantes' => $estudiantes,
            'temario'     => $temario,
            'tareas'      => $tareasPorUnidad,
            'objetivo'    => [
                'objetivo'           => $materia->objetivo,
                'caracterizacion'    => $materia->caracterizacion,
                'intencion_didactica' => $materia->intencion_didactica,
            ],
            'bibliografia' => $materia->bibliografia ?? '',
        ]);
    }

    public function guardarBibliografia(Request $request, int $id_grupo)
    {
        $docente = auth('docente')->user();

        $grupo = Grupo::where('id_grupo', $id_grupo)
            ->where('id_docente', $docente->id_docente)
            ->with('materia')
            ->firstOrFail();

        $request->validate(['texto' => 'nullable|string']);

        $grupo->materia->update(['bibliografia' => $request->texto]);

        return response()->json(['ok' => true]);
    }

    public function crearTarea(Request $request, int $id_grupo)
    {
        $docente = auth('docente')->user();

        abort_unless(
            Grupo::where('id_grupo', $id_grupo)
                ->where('id_docente', $docente->id_docente)
                ->exists(),
            403
        );

        $request->validate([
            'numero_unidad' => 'required|integer|min:1|max:10',
            'titulo'        => 'required|string|max:200',
            'descripcion'   => 'nullable|string',
            'fecha_entrega' => 'nullable|date',
        ]);

        $tarea = Tarea::create([
            'id_grupo'     => $id_grupo,
            'numero_unidad' => $request->numero_unidad,
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
        ]);

        return response()->json([
            'ok'     => true,
            'tarea'  => [
                'id_tarea'    => $tarea->id_tarea,
                'titulo'      => $tarea->titulo,
                'descripcion' => $tarea->descripcion,
                'fecha_entrega' => $tarea->fecha_entrega?->format('Y-m-d'),
            ],
        ]);
    }

    public function eliminarTarea(int $id_grupo, int $id_tarea)
    {
        $docente = auth('docente')->user();

        abort_unless(
            Grupo::where('id_grupo', $id_grupo)
                ->where('id_docente', $docente->id_docente)
                ->exists(),
            403
        );

        $tarea = Tarea::where('id_tarea', $id_tarea)
            ->where('id_grupo', $id_grupo)
            ->firstOrFail();

        $tarea->delete();

        return response()->json(['ok' => true]);
    }

    public function descargarEstudiantes(int $id_grupo)
    {
        $docente = auth('docente')->user();

        $grupo = Grupo::where('id_grupo', $id_grupo)
            ->where('id_docente', $docente->id_docente)
            ->with(['materia', 'cicloEscolar'])
            ->firstOrFail();

        $inscripciones = Inscripcion::where('id_grupo', $id_grupo)
            ->with('alumno')
            ->orderBy('id_inscripcion')
            ->get();

        $rows = [["Matrícula", "Nombre completo"]];
        foreach ($inscripciones as $ins) {
            $nombre = $ins->alumno
                ? trim("{$ins->alumno->nombre} {$ins->alumno->apellido_pat} {$ins->alumno->apellido_mat}")
                : 'Sin nombre';
            $rows[] = [$ins->alumno->matricula ?? '—', $nombre];
        }

        $csv = collect($rows)->map(fn ($r) => implode(',', array_map(fn ($v) => '"' . str_replace('"', '""', $v) . '"', $r)))->implode("\n");

        $filename = "estudiantes_{$grupo->materia->clave_materia}_G{$grupo->letra}.csv";

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}

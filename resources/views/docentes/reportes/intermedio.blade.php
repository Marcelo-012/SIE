<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte Intermedio — {{ $grupo->materia->nombre_materia ?? '' }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
        .page { padding: 24px 32px; max-width: 1000px; margin: 0 auto; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #7c3aed; padding-bottom: 12px; margin-bottom: 16px; }
        .header-left h1 { font-size: 15px; font-weight: 700; color: #7c3aed; }
        .header-left p { font-size: 10px; color: #64748b; margin-top: 2px; }
        .header-right { font-size: 10px; color: #64748b; text-align: right; }
        .meta-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px; }
        .meta-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 12px; }
        .meta-item .label { font-size: 9px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: .05em; }
        .meta-item .value { font-size: 11px; font-weight: 600; color: #1e293b; margin-top: 2px; }
        .section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #7c3aed; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th { background: #7c3aed; color: #fff; padding: 7px 8px; text-align: center; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
        thead th:first-child, thead th:nth-child(2) { text-align: left; }
        thead th:first-child { border-radius: 6px 0 0 0; }
        thead th:last-child { border-radius: 0 6px 0 0; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; font-size: 10px; text-align: center; }
        tbody td:first-child, tbody td:nth-child(2) { text-align: left; }
        .cal-cell { font-weight: 600; }
        .cal-ok { color: #16a34a; }
        .cal-bad { color: #dc2626; }
        .cal-na { color: #94a3b8; }
        .footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
        .print-btn { position: fixed; top: 16px; right: 16px; background: #7c3aed; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; cursor: pointer; font-weight: 600; }
        @media print { .print-btn { display: none; } body { font-size: 10px; } .page { padding: 16px; } }
    </style>
</head>
<body>
<button class="print-btn" onclick="window.print()">Imprimir / Guardar PDF</button>

<div class="page">
    <div class="header">
        <div class="header-left">
            <h1>Reporte Intermedio</h1>
            <p>{{ config('app.name') }}</p>
        </div>
        <div class="header-right">
            Generado: {{ now()->format('d/m/Y H:i') }}<br>
            Docente: {{ trim($docente->nombre . ' ' . $docente->apellido_pat . ' ' . $docente->apellido_mat) }}
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-item">
            <div class="label">Materia</div>
            <div class="value">{{ $grupo->materia->clave_materia }} — {{ $grupo->materia->nombre_materia }}</div>
        </div>
        <div class="meta-item">
            <div class="label">Grupo / Ciclo</div>
            <div class="value">{{ $grupo->letra }} — {{ $grupo->cicloEscolar->nombre_ciclo_escolar ?? '—' }}</div>
        </div>
        <div class="meta-item">
            <div class="label">Unidades</div>
            <div class="value">{{ $unidades }}</div>
        </div>
    </div>

    <div class="section-title">Calificaciones parciales</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th>Matrícula</th>
                <th>Eval. Diagnóstica</th>
                <th>Rte. Intermedio</th>
                @for($u = 1; $u <= $unidades; $u++)
                <th>Unidad {{ $u }}</th>
                @endfor
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscripciones as $i => $ins)
            @php
                $meta = $ins->calificaciones->first();
                $diagn = $meta?->cal_diagnostica;
                $rept  = $meta?->cal_reporte_intermedio;
                $calsUnidad = [];
                for ($u = 1; $u <= $unidades; $u++) {
                    $c = $ins->calificaciones->firstWhere('unidad', $u);
                    $calsUnidad[$u] = $c?->calificacion;
                }
                $vals = array_filter($calsUnidad, fn($v) => $v !== null);
                $prom = count($vals) > 0 ? round(array_sum($vals) / count($vals), 1) : null;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ins->alumno ? trim("{$ins->alumno->nombre} {$ins->alumno->apellido_pat} {$ins->alumno->apellido_mat}") : '—' }}</td>
                <td>{{ $ins->alumno->matricula ?? $ins->id_alumno }}</td>
                <td class="cal-cell {{ $diagn !== null ? ($diagn >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $diagn ?? 'N/A' }}
                </td>
                <td class="cal-cell {{ $rept !== null ? ($rept >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $rept ?? 'N/A' }}
                </td>
                @for($u = 1; $u <= $unidades; $u++)
                <td class="cal-cell {{ isset($calsUnidad[$u]) ? ($calsUnidad[$u] >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $calsUnidad[$u] ?? 'N/A' }}
                </td>
                @endfor
                <td class="cal-cell {{ $prom !== null ? ($prom >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $prom ?? 'N/A' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="{{ 5 + $unidades }}" style="text-align:center;color:#94a3b8;">Sin alumnos registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>{{ config('app.name') }} — Reporte Intermedio</span>
        <span>{{ now()->format('d/m/Y') }}</span>
    </div>
</div>
</body>
</html>

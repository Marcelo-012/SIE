<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de Fin de Curso — {{ $grupo->materia->nombre_materia ?? '' }}</title>
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
        .summary-row { display: flex; gap: 12px; margin-bottom: 16px; }
        .summary-card { flex: 1; border-radius: 10px; padding: 10px 14px; }
        .summary-card.aprobados { background: #dcfce7; }
        .summary-card.reprobados { background: #fee2e2; }
        .summary-card.desertores { background: #fef9c3; }
        .summary-card .num { font-size: 20px; font-weight: 800; }
        .summary-card .lbl { font-size: 10px; font-weight: 600; margin-top: 2px; }
        .summary-card.aprobados .num { color: #16a34a; }
        .summary-card.reprobados .num { color: #dc2626; }
        .summary-card.desertores .num { color: #ca8a04; }
        .section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #7c3aed; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        thead th { background: #7c3aed; color: #fff; padding: 7px 8px; text-align: center; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
        thead th:first-child, thead th:nth-child(2) { text-align: left; }
        thead th:first-child { border-radius: 6px 0 0 0; }
        thead th:last-child { border-radius: 0 6px 0 0; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; font-size: 10px; text-align: center; }
        tbody td:first-child, tbody td:nth-child(2) { text-align: left; }
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 9px; font-weight: 700; }
        .aprobado { background: #dcfce7; color: #16a34a; }
        .reprobado { background: #fee2e2; color: #dc2626; }
        .cursando { background: #dbeafe; color: #1d4ed8; }
        .desertor { background: #fef9c3; color: #ca8a04; }
        .cal-ok { color: #16a34a; font-weight: 700; }
        .cal-bad { color: #dc2626; font-weight: 700; }
        .cal-na { color: #94a3b8; }
        .footer { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
        .firma { margin-top: 40px; display: flex; justify-content: flex-end; }
        .firma-box { text-align: center; width: 200px; }
        .firma-line { border-top: 1px solid #1e293b; padding-top: 6px; font-size: 10px; }
        .print-btn { position: fixed; top: 16px; right: 16px; background: #7c3aed; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; cursor: pointer; font-weight: 600; }
        @media print { .print-btn { display: none; } body { font-size: 10px; } .page { padding: 16px; } }
    </style>
</head>
<body>
<button class="print-btn" onclick="window.print()">Imprimir / Guardar PDF</button>

<div class="page">
    <div class="header">
        <div class="header-left">
            <h1>Reporte de Fin de Curso</h1>
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
            <div class="label">Total inscritos</div>
            <div class="value">{{ $inscripciones->count() }}</div>
        </div>
    </div>

    @php
        $aprobados  = $inscripciones->where('estatus', 'aprobado')->count();
        $reprobados = $inscripciones->where('estatus', 'reprobado')->count();
        $cursando   = $inscripciones->where('estatus', 'cursando')->count();
    @endphp
    <div class="summary-row">
        <div class="summary-card aprobados">
            <div class="num">{{ $aprobados }}</div>
            <div class="lbl">Aprobados</div>
        </div>
        <div class="summary-card reprobados">
            <div class="num">{{ $reprobados }}</div>
            <div class="lbl">Reprobados / Desertores</div>
        </div>
        <div class="summary-card desertores">
            <div class="num">{{ $cursando }}</div>
            <div class="lbl">En curso (sin calificar)</div>
        </div>
    </div>

    <div class="section-title">Calificaciones finales</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th>Matrícula</th>
                @for($u = 1; $u <= $unidades; $u++)
                <th>U{{ $u }}</th>
                @endfor
                <th>Promedio</th>
                <th>Cal. Final</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscripciones as $i => $ins)
            @php
                $meta = $ins->calificaciones->first();
                $calFinal = $meta?->califiacion_final;
                $calsUnidad = [];
                for ($u = 1; $u <= $unidades; $u++) {
                    $c = $ins->calificaciones->firstWhere('unidad', $u);
                    $calsUnidad[$u] = $c?->calificacion;
                }
                $vals = array_filter($calsUnidad, fn($v) => $v !== null);
                $prom = count($vals) > 0 ? round(array_sum($vals) / count($vals), 1) : null;
                $badgeClass = match($ins->estatus) {
                    'aprobado'  => 'aprobado',
                    'reprobado' => $ins->estatus === 'reprobado' ? 'reprobado' : 'desertor',
                    default     => 'cursando',
                };
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ins->alumno ? trim("{$ins->alumno->nombre} {$ins->alumno->apellido_pat} {$ins->alumno->apellido_mat}") : '—' }}</td>
                <td>{{ $ins->alumno->matricula ?? $ins->id_alumno }}</td>
                @for($u = 1; $u <= $unidades; $u++)
                <td class="{{ isset($calsUnidad[$u]) ? ($calsUnidad[$u] >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $calsUnidad[$u] ?? '—' }}
                </td>
                @endfor
                <td class="{{ $prom !== null ? ($prom >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $prom ?? '—' }}
                </td>
                <td class="{{ $calFinal !== null ? ($calFinal >= 70 ? 'cal-ok' : 'cal-bad') : 'cal-na' }}">
                    {{ $calFinal ?? '—' }}
                </td>
                <td><span class="status-badge {{ $badgeClass }}">{{ ucfirst($ins->estatus) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="{{ 5 + $unidades }}" style="text-align:center;color:#94a3b8;">Sin alumnos registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="firma">
        <div class="firma-box">
            <div class="firma-line">
                {{ trim($docente->nombre . ' ' . $docente->apellido_pat . ' ' . $docente->apellido_mat) }}<br>
                Docente
            </div>
        </div>
    </div>

    <div class="footer">
        <span>{{ config('app.name') }} — Reporte de Fin de Curso</span>
        <span>{{ now()->format('d/m/Y') }}</span>
    </div>
</div>
</body>
</html>

{{-- resources/views/docentes/perfil/informacion-personal.blade.php --}}

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Información Personal
        </h2>
    </x-slot>

    {{-- ── Estilos ─────────────────────────────────────────────────── --}}
    <style>
        :root {
            --brand-dark:  #1e3a5f;
            --brand-mid:   #2563eb;
            --brand-soft:  #dbeafe;
            --brand-pale:  #eff6ff;
            --card-border: #bfdbfe;
            --text-primary:#1e293b;
            --text-muted:  #64748b;
            --radius-card: 0.75rem;
        }

        /* ── Tarjetas ─────────────────────────────────────────────── */
        .card-header-blue {
            background-color: var(--brand-soft);
            border-bottom: 2px solid var(--card-border);
            padding: .55rem 1rem;
            border-radius: var(--radius-card) var(--radius-card) 0 0;
        }
        .card-header-blue h2 {
            color: var(--brand-dark);
            font-size: .875rem;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
        }
        .card-body {
            background: #fff;
            border: 1px solid var(--card-border);
            border-top: none;
            border-radius: 0 0 var(--radius-card) var(--radius-card);
            padding: 1rem;
        }
        .profile-card {
            border-radius: var(--radius-card);
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(30,58,95,.08);
            margin-bottom: 1rem;
        }

        /* ── Filas dato/valor ─────────────────────────────────────── */
        .info-row {
            display: flex;
            flex-wrap: wrap;
            gap: .1rem .5rem;
            padding: .38rem 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: .82rem;
            line-height: 1.5;
            align-items: center;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--text-muted); min-width: 138px; flex-shrink: 0; }
        .info-value  { color: var(--text-primary); font-weight: 600; flex: 1; }

        /* ── Inputs en modo edición ───────────────────────────────── */
        .info-input {
            flex: 1;
            border: 1px solid var(--card-border);
            border-radius: .45rem;
            padding: .28rem .6rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--brand-pale);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
            min-width: 0;
        }
        .info-input:focus {
            border-color: var(--brand-mid);
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
            background: #fff;
        }
        select.info-input { cursor: pointer; }

        /* ── Avatar ───────────────────────────────────────────────── */
        .avatar-wrapper {
            width: 96px; height: 96px; border-radius: 50%;
            background: var(--brand-soft); border: 3px solid var(--brand-mid);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; margin: 0 auto .75rem; flex-shrink: 0;
        }
        .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }

        /* ── Badges ───────────────────────────────────────────────── */
        .badge-activo   { background:#dcfce7; color:#166534; }
        .badge-inactivo { background:#fee2e2; color:#991b1b; }
        .status-badge {
            display: inline-block; padding: .1rem .6rem;
            border-radius: 9999px; font-size: .7rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        }

        /* ── Plazas ───────────────────────────────────────────────── */
        .plaza-item {
            border-left: 3px solid var(--brand-mid);
            padding: .4rem .6rem; margin-bottom: .5rem;
            background: var(--brand-pale);
            border-radius: 0 .4rem .4rem 0; font-size: .78rem;
        }
        .plaza-item:last-child { margin-bottom: 0; }
        .plaza-title { font-weight: 700; color: var(--brand-dark); }
        .plaza-meta  { color: var(--text-muted); }

        /* ── Banner modo edición ──────────────────────────────────── */
        .edit-banner {
            background: linear-gradient(90deg, #1e3a5f 0%, #2563eb 100%);
            border-radius: .65rem;
            padding: .7rem 1.1rem;
            display: flex; align-items: center; gap: .75rem;
            margin-bottom: 1.25rem;
        }
        .edit-banner p { color: #fff; font-size: .82rem; font-weight: 500; }

        /* ── Botones ──────────────────────────────────────────────── */
        .btn-action {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .45rem 1.1rem; border-radius: .55rem;
            font-size: .82rem; font-weight: 600; cursor: pointer;
            transition: all .15s; border: none; outline: none;
        }
        .btn-primary   { background: var(--brand-dark); color: #fff; }
        .btn-primary:hover { background: #162d4a; box-shadow: 0 2px 8px rgba(30,58,95,.25); }
        .btn-secondary { background: #f1f5f9; color: var(--text-primary); border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-success   { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; box-shadow: 0 2px 8px rgba(22,163,74,.25); }
    </style>

    @php
        $nacimiento     = $usuario->fecha_nacimiento
            ? \Carbon\Carbon::parse($usuario->fecha_nacimiento) : null;
        $antiguedadDate = $usuario->antiguedad
            ? \Carbon\Carbon::parse($usuario->antiguedad) : null;
    @endphp

    <div x-data="{ editando: false }" class="px-4 sm:px-6 pb-10 max-w-screen-xl mx-auto">

        {{-- Breadcrumb + botón Editar ──────────────────────────────── --}}
        <div class="flex flex-wrap items-center justify-between gap-3 py-4">
            <div>
                <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-1">
                    <a href="{{ route('docente.dashboard') }}"
                       class="hover:text-blue-600 transition-colors">Inicio</a>
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                    </svg>
                    <span class="font-medium" style="color:var(--brand-dark)">Información Personal</span>
                </div>
                <h1 class="text-xl font-bold" style="color:var(--brand-dark)">Perfil del Docente</h1>
            </div>

            <div class="flex items-center gap-2">
                <button x-show="!editando" @click="editando = true"
                        class="btn-action btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar datos
                </button>
                <button x-show="editando" @click="editando = false" x-transition
                        class="btn-action btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </button>
            </div>
        </div>

        {{-- Banner modo edición ────────────────────────────────────── --}}
        <div x-show="editando"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="edit-banner">
            <svg class="w-5 h-5 text-blue-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>Estás en <strong>modo edición</strong>. Modifica los campos y presiona
                <strong>Guardar cambios</strong> para aplicar.</p>
        </div>

        {{-- FORMULARIO ──────────────────────────────────────────────── --}}
        <form method="POST" action="{{ route('docentes.perfil.actualizar') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">

                {{-- ══════════════════════════════════════════════════
                     COLUMNA IZQUIERDA
                ══════════════════════════════════════════════════ --}}
                <div>
                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información general</h2></div>
                        <div class="card-body flex flex-col items-center text-center pt-5">

                            <div class="avatar-wrapper">
                                @if($usuario->foto ?? null)
                                    <img src="{{ asset('storage/'.$usuario->foto) }}" alt="Foto">
                                @else
                                    <svg viewBox="0 0 100 100" class="w-full h-full text-blue-300" fill="currentColor">
                                        <circle cx="50" cy="36" r="22"/>
                                        <ellipse cx="50" cy="85" rx="34" ry="24"/>
                                    </svg>
                                @endif
                            </div>

                            <div x-show="editando" class="mb-3 w-full">
                                <label class="block text-xs text-gray-500 mb-1 text-left">Cambiar foto</label>
                                <input type="file" name="foto" accept="image/*"
                                       class="w-full text-xs text-gray-500
                                              file:mr-2 file:py-1.5 file:px-3 file:rounded-lg
                                              file:border-0 file:text-xs file:font-semibold
                                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <p class="font-bold text-base mb-3" style="color:var(--brand-dark)">
                                {{ $usuario->nombre }} {{ $usuario->apellido_pat }} {{ $usuario->apellido_mat }}
                            </p>

                            <div class="w-full text-left">

                                <div class="info-row">
                                    <span class="info-label">Nombre:</span>
                                    <span class="info-value" x-show="!editando">{{ $usuario->nombre }}</span>
                                    <input x-show="editando" type="text" name="nombre"
                                           value="{{ old('nombre', $usuario->nombre) }}"
                                           class="info-input" placeholder="Nombre(s)" required>
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Apellido paterno:</span>
                                    <span class="info-value" x-show="!editando">{{ $usuario->apellido_pat }}</span>
                                    <input x-show="editando" type="text" name="apellido_pat"
                                           value="{{ old('apellido_pat', $usuario->apellido_pat) }}"
                                           class="info-input" placeholder="Apellido paterno" required>
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Apellido materno:</span>
                                    <span class="info-value" x-show="!editando">{{ $usuario->apellido_mat }}</span>
                                    <input x-show="editando" type="text" name="apellido_mat"
                                           value="{{ old('apellido_mat', $usuario->apellido_mat) }}"
                                           class="info-input" placeholder="Apellido materno">
                                </div>

                                <div class="info-row">
                                    <span class="info-label">CURP:</span>
                                    <span class="info-value font-mono text-xs" x-show="!editando">{{ $usuario->curp ?? '—' }}</span>
                                    <input x-show="editando" type="text" name="curp"
                                           value="{{ old('curp', $usuario->curp) }}"
                                           maxlength="18" class="info-input font-mono"
                                           placeholder="18 caracteres" style="text-transform:uppercase">
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Fecha de nacimiento:</span>
                                    <span class="info-value" x-show="!editando">
                                        {{ $nacimiento ? $nacimiento->translatedFormat('d \d\e F \d\e Y') : '—' }}
                                    </span>
                                    <input x-show="editando" type="date" name="fecha_nacimiento"
                                           value="{{ old('fecha_nacimiento', $nacimiento ? $nacimiento->format('Y-m-d') : '') }}"
                                           class="info-input">
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Edad:</span>
                                    <span class="info-value">{{ $nacimiento ? $nacimiento->age : '—' }} años</span>
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Sexo:</span>
                                    <span class="info-value" x-show="!editando">{{ ucfirst($usuario->genero ?? '—') }}</span>
                                    <select x-show="editando" name="genero" class="info-input">
                                        <option value="masculino" @selected(($usuario->genero ?? '') === 'masculino')>Masculino</option>
                                        <option value="femenino"  @selected(($usuario->genero ?? '') === 'femenino')>Femenino</option>
                                    </select>
                                </div>

                                <div class="info-row">
                                    <span class="info-label">Estado civil:</span>
                                    <span class="info-value" x-show="!editando">{{ ucfirst($usuario->estado_civil ?? '—') }}</span>
                                    <select x-show="editando" name="estado_civil" class="info-input">
                                        @foreach(['soltero','casado','divorciado','viudo','otro'] as $ec)
                                            <option value="{{ $ec }}" @selected(($usuario->estado_civil ?? '') === $ec)>
                                                {{ ucfirst($ec) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════
                     COLUMNA CENTRAL
                ══════════════════════════════════════════════════ --}}
                <div class="flex flex-col gap-4">

                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información adicional</h2></div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">RFC:</span>
                                <span class="info-value font-mono text-xs" x-show="!editando">{{ $usuario->rfc ?? '—' }}</span>
                                <input x-show="editando" type="text" name="rfc"
                                       value="{{ old('rfc', $usuario->rfc) }}"
                                       maxlength="13" class="info-input font-mono"
                                       placeholder="13 caracteres" style="text-transform:uppercase">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Nivel de estudios:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->nivel_estudio ?? '—' }}</span>
                                <input x-show="editando" type="text" name="nivel_estudio"
                                       value="{{ old('nivel_estudio', $usuario->nivel_estudio) }}"
                                       class="info-input" placeholder="Ej. Profesional">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Antigüedad en el plantel:</span>
                                <span class="info-value">
                                    @if($antiguedadDate)
                                        {{ $antiguedadDate->diffInYears(now()) }} años
                                        (desde {{ $antiguedadDate->format('d/m/Y') }})
                                    @else —
                                    @endif
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Área de adscripción:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->area_adscripcion ?? '—' }}</span>
                                <input x-show="editando" type="text" name="area_adscripcion"
                                       value="{{ old('area_adscripcion', $usuario->area_adscripcion) }}"
                                       class="info-input" placeholder="Ej. Dept. de Sistemas">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Estatus:</span>
                                <span class="info-value">
                                    <span class="status-badge {{ ($usuario->status ?? '') === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                        {{ ucfirst($usuario->status ?? 'inactivo') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información del centro de trabajo</h2></div>
                        <div class="card-body">
                            @if($usuario->centroTrabajo ?? null)
                                <div class="info-row"><span class="info-label">Clave:</span><span class="info-value font-mono text-xs">{{ $usuario->centroTrabajo->clave ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Nombre:</span><span class="info-value">{{ $usuario->centroTrabajo->nombre ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Número:</span><span class="info-value">{{ $usuario->centroTrabajo->numero ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Zona:</span><span class="info-value">{{ $usuario->centroTrabajo->zona ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Entidad:</span><span class="info-value">{{ $usuario->centroTrabajo->entidad ?? '—' }}</span></div>
                            @else
                                <p class="text-sm" style="color:var(--text-muted)">Sin centro de trabajo asignado.</p>
                            @endif
                            <p class="text-xs mt-2 italic" style="color:var(--text-muted)">
                                ℹ️ Administrado por el sistema.
                            </p>
                        </div>
                    </div>

                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información sobre plazas</h2></div>
                        <div class="card-body">
                            @forelse($usuario->plazas ?? [] as $plaza)
                                <div class="plaza-item">
                                    <p class="plaza-title">{{ $plaza->descripcion }}</p>
                                    <p class="plaza-meta">Clave: <strong>{{ $plaza->clave }}</strong>
                                        &nbsp;·&nbsp; Tipo: <strong>{{ $plaza->tipo_nombramiento }}</strong></p>
                                </div>
                            @empty
                                <p class="text-sm" style="color:var(--text-muted)">No se encontraron plazas.</p>
                            @endforelse
                            <p class="text-xs mt-2 italic" style="color:var(--text-muted)">
                                ℹ️ Gestionado por administración.
                            </p>
                        </div>
                    </div>

                </div>{{-- /col central --}}

                {{-- ══════════════════════════════════════════════════
                     COLUMNA DERECHA
                ══════════════════════════════════════════════════ --}}
                <div class="flex flex-col gap-4">

                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información de contacto</h2></div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Calle y número:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->calle_numero ?? '—' }}</span>
                                <input x-show="editando" type="text" name="calle_numero"
                                       value="{{ old('calle_numero', $usuario->calle_numero) }}"
                                       class="info-input" placeholder="Calle y número">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Colonia:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->colonia ?? '—' }}</span>
                                <input x-show="editando" type="text" name="colonia"
                                       value="{{ old('colonia', $usuario->colonia) }}"
                                       class="info-input" placeholder="Colonia">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Municipio:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->municipio ?? '—' }}</span>
                                <input x-show="editando" type="text" name="municipio"
                                       value="{{ old('municipio', $usuario->municipio) }}"
                                       class="info-input" placeholder="Municipio">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Estado:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->estado ?? '—' }}</span>
                                <input x-show="editando" type="text" name="estado"
                                       value="{{ old('estado', $usuario->estado) }}"
                                       class="info-input" placeholder="Estado">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Código postal:</span>
                                <span class="info-value" x-show="!editando">{{ $usuario->codigo_postal ?? '—' }}</span>
                                <input x-show="editando" type="text" name="codigo_postal"
                                       value="{{ old('codigo_postal', $usuario->codigo_postal) }}"
                                       maxlength="5" class="info-input" placeholder="CP">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Teléfono:</span>
                                <span class="info-value" x-show="!editando">
                                    @if($usuario->telefono)
                                        <a href="tel:{{ $usuario->telefono }}" class="hover:underline" style="color:var(--brand-mid)">{{ $usuario->telefono }}</a>
                                    @else —
                                    @endif
                                </span>
                                <input x-show="editando" type="tel" name="telefono"
                                       value="{{ old('telefono', $usuario->telefono) }}"
                                       maxlength="10" class="info-input" placeholder="10 dígitos">
                            </div>
                            <div class="info-row">
                                <span class="info-label">Correo:</span>
                                <span class="info-value break-all" x-show="!editando">
                                    @if($usuario->correo)
                                        <a href="mailto:{{ $usuario->correo }}" class="hover:underline" style="color:var(--brand-mid)">{{ $usuario->correo }}</a>
                                    @else —
                                    @endif
                                </span>
                                <input x-show="editando" type="email" name="correo"
                                       value="{{ old('correo', $usuario->correo) }}"
                                       class="info-input" placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                    </div>

                    <div class="profile-card">
                        <div class="card-header-blue"><h2>Información del nombramiento</h2></div>
                        <div class="card-body">
                            @if($usuario->nombramiento ?? null)
                                <div class="info-row"><span class="info-label">Tipo:</span><span class="info-value">{{ $usuario->nombramiento->tipo ?? '—' }}</span></div>
                                <div class="info-row">
                                    <span class="info-label">Ingreso rama:</span>
                                    <span class="info-value">{{ isset($usuario->nombramiento->ingreso_rama) ? \Carbon\Carbon::parse($usuario->nombramiento->ingreso_rama)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Inicio gobierno:</span>
                                    <span class="info-value">{{ isset($usuario->nombramiento->inicio_gobierno) ? \Carbon\Carbon::parse($usuario->nombramiento->inicio_gobierno)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Inicio SEP:</span>
                                    <span class="info-value">{{ isset($usuario->nombramiento->inicio_sep) ? \Carbon\Carbon::parse($usuario->nombramiento->inicio_sep)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Inicio plantel:</span>
                                    <span class="info-value">{{ isset($usuario->nombramiento->inicio_plantel) ? \Carbon\Carbon::parse($usuario->nombramiento->inicio_plantel)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                </div>
                            @else
                                <p class="text-sm" style="color:var(--text-muted)">Sin información de nombramiento.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Botón Guardar (solo en edición) --}}
                    <div x-show="editando"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex justify-end gap-3">
                        <button type="button" @click="editando = false" class="btn-action btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </button>
                        <button type="submit" class="btn-action btn-success">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar cambios
                        </button>
                    </div>

                </div>{{-- /col derecha --}}

            </div>{{-- /grid --}}
        </form>

        {{-- Toast éxito --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 4000)" x-transition
             class="fixed bottom-6 right-6 z-50 bg-green-600 text-white text-sm font-semibold
                    px-5 py-3 rounded-xl shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Toast errores --}}
        @if($errors->any())
        <div x-data="{ show: true }" x-show="show"
             class="fixed bottom-6 right-6 z-50 bg-red-600 text-white text-sm
                    px-5 py-3 rounded-xl shadow-lg max-w-xs">
            <div class="flex justify-between items-start gap-3">
                <div>
                    <p class="font-bold mb-1">Revisa los errores:</p>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="text-red-200 hover:text-white mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

    </div>{{-- /x-data --}}

</x-app-layout>
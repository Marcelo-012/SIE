<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Tokens de perfil (heredados de informacion-personal) ─── */
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
        .card-header-blue {
            background-color: var(--brand-soft);
            border-bottom: 2px solid var(--card-border);
            padding: .55rem 1rem;
            border-radius: var(--radius-card) var(--radius-card) 0 0;
        }
        .card-header-blue h2 {
            color: var(--brand-dark);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .04em;
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
        .info-row {
            display: flex;
            flex-wrap: wrap;
            gap: .1rem .5rem;
            padding: .35rem 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: .8rem;
            line-height: 1.4;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--text-muted); min-width: 130px; flex-shrink: 0; }
        .info-value  { color: var(--text-primary); font-weight: 600; flex: 1; }
        .avatar-wrapper {
            width: 88px; height: 88px; border-radius: 50%;
            background: var(--brand-soft); border: 3px solid var(--brand-mid);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; margin: 0 auto .75rem; flex-shrink: 0;
        }
        .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .badge-activo   { background:#dcfce7; color:#166534; }
        .badge-inactivo { background:#fee2e2; color:#991b1b; }
        .status-badge {
            display: inline-block; padding: .1rem .6rem;
            border-radius: 9999px; font-size: .68rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        }
        .plaza-item {
            border-left: 3px solid var(--brand-mid);
            padding: .4rem .6rem; margin-bottom: .5rem;
            background: var(--brand-pale);
            border-radius: 0 .4rem .4rem 0; font-size: .78rem;
        }
        .plaza-item:last-child { margin-bottom: 0; }
        .plaza-title { font-weight: 700; color: var(--brand-dark); }
        .plaza-meta  { color: var(--text-muted); }

        /* ── Opciones / Cambiar contraseña ─────────────────── */
        .pass-group { margin-bottom: 1.1rem; }
        .pass-label {
            display: block; font-size: .82rem; font-weight: 600;
            color: var(--text-primary); margin-bottom: .35rem;
        }
        .pass-label span { color: #e53e3e; margin-left: 1px; }
        .pass-wrapper { position: relative; display: flex; align-items: center; }
        .pass-input {
            width: 100%; border: 1.5px solid #cbd5e1; border-radius: .55rem;
            padding: .6rem .9rem; padding-right: 2.6rem; font-size: .88rem;
            color: var(--text-primary); background: #fff; outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .pass-input:focus {
            border-color: var(--brand-mid);
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .pass-input.is-error { border-color: #e53e3e; box-shadow: 0 0 0 3px rgba(229,62,62,.1); }
        .pass-toggle {
            position: absolute; right: .7rem; color: #94a3b8;
            cursor: pointer; background: none; border: none; padding: 0;
            display: flex; align-items: center; transition: color .15s;
        }
        .pass-toggle:hover { color: var(--brand-mid); }
        .req-list { list-style: none; padding: 0; margin: .5rem 0 0; display: flex; flex-wrap: wrap; gap: .3rem .9rem; }
        .req-item { font-size: .72rem; color: var(--text-muted); display: flex; align-items: center; gap: .3rem; }
        .req-item .dot { width: 6px; height: 6px; border-radius: 50%; background: #cbd5e1; flex-shrink: 0; transition: background .2s; }
        .req-item.ok .dot { background: #16a34a; }
        .req-item.ok    { color: #16a34a; }
        .btn-cambiar {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .55rem 1.4rem; border-radius: .55rem;
            background: var(--brand-dark); color: #fff;
            font-size: .85rem; font-weight: 700; border: none; cursor: pointer;
            outline: none; transition: background .15s, box-shadow .15s;
        }
        .btn-cambiar:hover { background: #162d4a; box-shadow: 0 3px 10px rgba(30,58,95,.3); }
        .btn-cambiar:active { transform: scale(.98); }
        .field-error { font-size: .72rem; color: #e53e3e; margin-top: .25rem; }
    </style>
</head>
<body class="bg-slate-100 font-sans antialiased">

@php
    /** @var \App\Models\Docente $docente */
    $docente  = auth('docente')->user();
    $nombre   = $docente->nombre   ?? '';
    $apePat   = $docente->apellido_pat ?? '';
    $apeMat   = $docente->apellido_mat ?? '';
    $fullName = trim("$nombre $apePat $apeMat");
    $initials = strtoupper(
        mb_substr($nombre, 0, 1) .
        mb_substr($apePat, 0, 1)
    );

    $nacimiento     = $docente->fecha_nacimiento
        ? \Carbon\Carbon::parse($docente->fecha_nacimiento)
        : null;
    $antiguedadDate = $docente->antiguedad
        ? \Carbon\Carbon::parse($docente->antiguedad)
        : null;
@endphp

{{-- ================================================================
     LAYOUT RAÍZ
================================================================ --}}
<div class="flex h-screen overflow-hidden"
     x-data="{
         sidebarOpen:     true,
         paginaActiva:    '{{ session('activeTab', 'inicio') }}',
         cursosOpen:      {{ in_array(session('activeTab', 'inicio'), ['cursos','grupos','propedeutico','tutorias']) ? 'true' : 'false' }},
         opcionesOpen:    {{ session('activeTab', 'inicio') === 'opciones' ? 'true' : 'false' }},
         opcionSubActiva: 'cambiar'
     }">

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'"
        class="flex-shrink-0 bg-white border-r border-slate-100 flex flex-col
               transition-all duration-300 ease-in-out select-none">

        {{-- Logo MindBox --}}
        <div class="flex items-center gap-2.5 px-5 pt-6 pb-5">
            <div class="bg-purple-700 rounded-xl p-2 flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>
                </svg>
            </div>
            <span class="font-bold text-gray-800 text-lg tracking-tight whitespace-nowrap">MindBox</span>
        </div>

        {{-- Buscador --}}
        <div class="px-4 mb-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
                <input type="search" placeholder="Buscar..."
                       class="w-full pl-9 pr-3 py-2 bg-slate-100 border-0 rounded-xl text-sm
                              text-gray-600 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-purple-300 focus:bg-white
                              transition-colors">
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">

            {{-- Inicio --}}
            <button @click="paginaActiva = 'inicio'"
                    :class="paginaActiva === 'inicio'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="whitespace-nowrap">Inicio</span>
                <template x-if="paginaActiva === 'inicio'">
                    <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                </template>
            </button>

            {{-- Cursos (con submenú expandible) --}}
            <div>
                <button @click="cursosOpen = !cursosOpen; if (!cursosOpen) paginaActiva = 'cursos'"
                        :class="['cursos','grupos','propedeutico','tutorias'].includes(paginaActiva)
                            ? 'bg-purple-50 text-purple-700 font-semibold'
                            : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="whitespace-nowrap">Cursos</span>
                    <svg :class="cursosOpen ? 'rotate-90' : ''"
                         class="ml-auto w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Submenú de Cursos --}}
                <div x-show="cursosOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-0.5 ml-3 pl-3 border-l-2 border-slate-100 space-y-0.5">

                    {{-- Grupos --}}
                    <button @click="paginaActiva = 'grupos'"
                            :class="paginaActiva === 'grupos'
                                ? 'bg-purple-50 text-purple-700 font-semibold'
                                : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="whitespace-nowrap">Grupos</span>
                        <template x-if="paginaActiva === 'grupos'">
                            <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                        </template>
                    </button>

                    {{-- Propedéutico --}}
                    <button @click="paginaActiva = 'propedeutico'"
                            :class="paginaActiva === 'propedeutico'
                                ? 'bg-purple-50 text-purple-700 font-semibold'
                                : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span class="whitespace-nowrap">Propedéutico</span>
                        <template x-if="paginaActiva === 'propedeutico'">
                            <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                        </template>
                    </button>

                    {{-- Tutorías --}}
                    <button @click="paginaActiva = 'tutorias'"
                            :class="paginaActiva === 'tutorias'
                                ? 'bg-purple-50 text-purple-700 font-semibold'
                                : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="whitespace-nowrap">Tutorías</span>
                        <template x-if="paginaActiva === 'tutorias'">
                            <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                        </template>
                    </button>
                </div>
            </div>

            <div class="my-2 border-t border-slate-100"></div>

            {{-- Mis datos --}}
            <button @click="paginaActiva = 'mis-datos'"
                    :class="paginaActiva === 'mis-datos'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="whitespace-nowrap">Mis datos</span>
                <template x-if="paginaActiva === 'mis-datos'">
                    <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                </template>
            </button>

            {{-- Opciones (con submenú expandible) --}}
            <div>
                <button @click="opcionesOpen = !opcionesOpen; if (!opcionesOpen) paginaActiva = 'inicio'"
                        :class="paginaActiva === 'opciones'
                            ? 'bg-purple-50 text-purple-700 font-semibold'
                            : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="whitespace-nowrap">Opciones</span>
                    <svg :class="opcionesOpen ? 'rotate-90' : ''"
                         class="ml-auto w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Submenú de Opciones --}}
                <div x-show="opcionesOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-0.5 ml-3 pl-3 border-l-2 border-slate-100 space-y-0.5">

                    {{-- Cambiar contraseña --}}
                    <button @click="paginaActiva = 'opciones'; opcionSubActiva = 'cambiar'; opcionesOpen = true"
                            :class="paginaActiva === 'opciones' && opcionSubActiva === 'cambiar'
                                ? 'bg-purple-50 text-purple-700 font-semibold'
                                : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span class="whitespace-nowrap">Cambiar contraseña</span>
                        <template x-if="paginaActiva === 'opciones' && opcionSubActiva === 'cambiar'">
                            <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                        </template>
                    </button>

                    {{-- Cerrar sesión --}}
                    <button @click="paginaActiva = 'opciones'; opcionSubActiva = 'cerrar'; opcionesOpen = true"
                            :class="paginaActiva === 'opciones' && opcionSubActiva === 'cerrar'
                                ? 'bg-red-50 text-red-600 font-semibold'
                                : 'text-gray-500 hover:bg-red-50 hover:text-red-500'"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="whitespace-nowrap">Cerrar sesión</span>
                        <template x-if="paginaActiva === 'opciones' && opcionSubActiva === 'cerrar'">
                            <div class="ml-auto w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                        </template>
                    </button>

                </div>
            </div>
        </nav>

        {{-- Ocultar menú --}}
        <div class="px-3 py-4 border-t border-slate-100">
            <button @click="sidebarOpen = false"
                    class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm
                           text-gray-400 hover:bg-slate-50 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <span class="whitespace-nowrap text-xs font-medium">Ocultar menú</span>
            </button>
        </div>
    </aside>

    {{-- ============================================================
         ÁREA PRINCIPAL
    ============================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- ── HEADER ─────────────────────────────────────────────── --}}
        <header class="bg-white border-b border-slate-100 flex items-center px-6 py-3 gap-4 flex-shrink-0">

            <button x-show="!sidebarOpen"
                    @click="sidebarOpen = true"
                    class="p-2 rounded-lg text-gray-400 hover:bg-slate-50 hover:text-gray-600 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo institucional --}}
            <div class="flex-1 flex items-center justify-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-700 to-red-900
                            rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-widest leading-none mb-0.5">Instituto Tecnológico de</p>
                    <p class="text-sm font-bold text-gray-800 tracking-wide uppercase leading-none">Pinotepa</p>
                </div>
            </div>

            {{-- Usuario --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $fullName }}</p>
                    <p class="text-xs text-gray-400">Docente</p>
                </div>
                <div class="w-9 h-9 bg-gradient-to-br from-purple-600 to-indigo-700 rounded-full
                            flex items-center justify-center flex-shrink-0 shadow-sm cursor-pointer
                            hover:opacity-90 transition-opacity"
                     @click="paginaActiva = 'mis-datos'"
                     title="Ver mi perfil">
                    <span class="text-white text-xs font-bold">{{ $initials }}</span>
                </div>
            </div>
        </header>

        {{-- ── CONTENIDO PRINCIPAL ────────────────────────────────── --}}
        <main class="flex-1 overflow-y-auto bg-slate-100">

            {{-- ══════════════════════════════════════════════════════
                 PANEL: INICIO
            ══════════════════════════════════════════════════════ --}}
            <div x-show="paginaActiva === 'inicio'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="p-6 lg:p-8">

                <div class="mb-6">
                    <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight uppercase">
                        ¡Bienvenido {{ strtoupper($nombre) }}!
                    </h1>
                    <p class="text-sm text-gray-400 mt-0.5">
                        {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </p>
                </div>

                {{-- Grid de tarjetas 2×2 --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

                    @php
                        $cards = [
                            [
                                'key'   => 'cursos',
                                'label' => 'Cursos',
                                'desc'  => 'Gestiona tus materias asignadas',
                                'bg'    => 'bg-purple-50 hover:bg-purple-100 border-purple-100 hover:border-purple-200',
                                'icon-bg'   => 'bg-purple-100 group-hover:bg-purple-200',
                                'icon-text' => 'text-purple-600',
                                'grad-from' => '#a855f7', 'grad-to' => '#7c3aed',
                                'icon' => 'book',
                            ],
                            [
                                'key'   => 'mis-datos',
                                'label' => 'Mis datos',
                                'desc'  => 'Información personal y académica',
                                'bg'    => 'bg-blue-50 hover:bg-blue-100 border-blue-100 hover:border-blue-200',
                                'icon-bg'   => 'bg-blue-100 group-hover:bg-blue-200',
                                'icon-text' => 'text-blue-600',
                                'grad-from' => '#38bdf8', 'grad-to' => '#2563eb',
                                'icon' => 'id',
                            ],
                            [
                                'key'   => 'propedeutico',
                                'label' => 'Propedéutico',
                                'desc'  => 'Módulo de seguimiento propedéutico',
                                'bg'    => 'bg-amber-50 hover:bg-amber-100 border-amber-100 hover:border-amber-200',
                                'icon-bg'   => 'bg-amber-100 group-hover:bg-amber-200',
                                'icon-text' => 'text-amber-600',
                                'grad-from' => '#fbbf24', 'grad-to' => '#d97706',
                                'icon' => 'flask',
                            ],
                            [
                                'key'   => 'tutorias',
                                'label' => 'Tutorías',
                                'desc'  => 'Seguimiento a alumnos tutorados',
                                'bg'    => 'bg-emerald-50 hover:bg-emerald-100 border-emerald-100 hover:border-emerald-200',
                                'icon-bg'   => 'bg-emerald-100 group-hover:bg-emerald-200',
                                'icon-text' => 'text-emerald-600',
                                'grad-from' => '#34d399', 'grad-to' => '#059669',
                                'icon' => 'chat',
                            ],
                        ];
                    @endphp

                    @foreach($cards as $i => $card)
                    <button @click="paginaActiva = '{{ $card['key'] }}'"
                            class="group {{ $card['bg'] }} border rounded-2xl p-5 flex items-center gap-4
                                   transition-all text-left hover:shadow-md active:scale-[0.98]">
                        <div class="w-12 h-12 {{ $card['icon-bg'] }} rounded-xl
                                    flex items-center justify-center flex-shrink-0 transition-colors">
                            @if($card['icon'] === 'book')
                            <svg class="w-6 h-6 {{ $card['icon-text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            @elseif($card['icon'] === 'id')
                            <svg class="w-6 h-6 {{ $card['icon-text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 2 1.5 3 3 3s3-1 3-3"/>
                            </svg>
                            @elseif($card['icon'] === 'flask')
                            <svg class="w-6 h-6 {{ $card['icon-text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            @else
                            <svg class="w-6 h-6 {{ $card['icon-text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-800 text-base">{{ $card['label'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $card['desc'] }}</p>
                        </div>
                        <div class="w-10 h-10 flex-shrink-0">
                            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                <defs>
                                    <linearGradient id="grad-card-{{ $i }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%"   style="stop-color:{{ $card['grad-from'] }}"/>
                                        <stop offset="100%" style="stop-color:{{ $card['grad-to'] }}"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#grad-card-{{ $i }})"
                                      d="M50,5 A45,45 0 1,1 5,50 A45,45 0 0,1 50,5 Z M50,18 A32,32 0 1,0 82,50 A32,32 0 0,0 50,18 Z"/>
                                <polygon fill="url(#grad-card-{{ $i }})" points="50,2 58,20 42,20"/>
                                <polygon fill="url(#grad-card-{{ $i }})" points="98,50 80,42 80,58"/>
                            </svg>
                        </div>
                    </button>
                    @endforeach

                </div>{{-- /grid --}}

                {{-- Avisos --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base font-bold text-gray-700 uppercase tracking-wide">Avisos</h2>
                        <span class="text-xs text-gray-400">{{ now()->format('d/m/Y') }}</span>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="flex flex-col items-center justify-center py-14 px-8 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm font-medium">Al parecer no tienes nada importante que ver por aquí...</p>
                            <p class="text-gray-300 text-xs mt-1">Los avisos del coordinador aparecerán en este espacio.</p>
                        </div>
                    </div>
                </div>

            </div>{{-- /panel inicio --}}

            {{-- ══════════════════════════════════════════════════════
                 PANEL: MIS DATOS — Información Personal
            ══════════════════════════════════════════════════════ --}}
            <div x-show="paginaActiva === 'mis-datos'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="p-6 lg:p-8">

                {{-- Encabezado de sección --}}
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                            <button @click="paginaActiva='inicio'" class="hover:text-purple-600 transition-colors">Inicio</button>
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            <span class="font-medium" style="color:var(--brand-dark)">Mis datos</span>
                        </div>
                        <h1 class="text-xl font-extrabold" style="color:var(--brand-dark)">
                            Información Personal
                        </h1>
                    </div>
                </div>

                {{-- GRID 3 columnas --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">

                    {{-- ── Columna izquierda ── --}}
                    <div>
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información general</h2></div>
                            <div class="card-body flex flex-col items-center text-center pt-5">

                                {{-- Avatar --}}
                                <div class="avatar-wrapper">
                                    @if($docente->foto ?? null)
                                        <img src="{{ asset('storage/'.$docente->foto) }}" alt="Foto">
                                    @else
                                        <svg viewBox="0 0 100 100" class="w-full h-full text-blue-300" fill="currentColor">
                                            <circle cx="50" cy="36" r="22"/>
                                            <ellipse cx="50" cy="85" rx="34" ry="24"/>
                                        </svg>
                                    @endif
                                </div>

                                <p class="font-bold text-sm" style="color:var(--brand-dark)">{{ $fullName }}</p>

                                <div class="w-full mt-3 text-left">
                                    <div class="info-row">
                                        <span class="info-label">Nombre:</span>
                                        <span class="info-value">{{ $nombre }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Apellidos:</span>
                                        <span class="info-value">{{ $apePat }} {{ $apeMat }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">CURP:</span>
                                        <span class="info-value font-mono" style="font-size:.7rem">{{ $docente->curp ?? '—' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Fecha de nacimiento:</span>
                                        <span class="info-value">
                                            {{ $nacimiento ? $nacimiento->translatedFormat('d \d\e F \d\e Y') : '—' }}
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Edad:</span>
                                        <span class="info-value">{{ $nacimiento ? $nacimiento->age : '—' }} años</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Sexo:</span>
                                        <span class="info-value">{{ ucfirst($docente->genero ?? '—') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Estado civil:</span>
                                        <span class="info-value">{{ ucfirst($docente->estado_civil ?? '—') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Columna central ── --}}
                    <div class="flex flex-col gap-4">

                        {{-- Información adicional --}}
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información adicional</h2></div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="info-label">RFC:</span>
                                    <span class="info-value font-mono" style="font-size:.7rem">{{ $docente->rfc ?? '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Nivel de estudios:</span>
                                    <span class="info-value">{{ $docente->nivel_estudio ?? '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Antigüedad en el plantel:</span>
                                    <span class="info-value">
                                        @if($antiguedadDate)
                                            {{ $antiguedadDate->diffInYears(now()) }} años
                                            (desde {{ $antiguedadDate->translatedFormat('d/m/Y') }})
                                        @else —
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Área de adscripción:</span>
                                    <span class="info-value">{{ $docente->area_adscripcion ?? '—' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Estatus:</span>
                                    <span class="info-value">
                                        <span class="status-badge {{ ($docente->status ?? '') === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                            {{ ucfirst($docente->status ?? 'inactivo') }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Centro de trabajo --}}
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información del centro de trabajo</h2></div>
                            <div class="card-body">
                                @if($docente->centroTrabajo ?? null)
                                    <div class="info-row"><span class="info-label">Clave:</span><span class="info-value font-mono" style="font-size:.7rem">{{ $docente->centroTrabajo->clave ?? '—' }}</span></div>
                                    <div class="info-row"><span class="info-label">Nombre:</span><span class="info-value">{{ $docente->centroTrabajo->nombre ?? '—' }}</span></div>
                                    <div class="info-row"><span class="info-label">Número:</span><span class="info-value">{{ $docente->centroTrabajo->numero ?? '—' }}</span></div>
                                    <div class="info-row"><span class="info-label">Zona:</span><span class="info-value">{{ $docente->centroTrabajo->zona ?? '—' }}</span></div>
                                    <div class="info-row"><span class="info-label">Entidad:</span><span class="info-value">{{ $docente->centroTrabajo->entidad ?? '—' }}</span></div>
                                @else
                                    <p class="text-sm" style="color:var(--text-muted)">Sin centro de trabajo asignado.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Plazas --}}
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información sobre plazas</h2></div>
                            <div class="card-body">
                                @forelse($docente->plazas ?? [] as $plaza)
                                    <div class="plaza-item">
                                        <p class="plaza-title">{{ $plaza->descripcion }}</p>
                                        <p class="plaza-meta">Clave: <strong>{{ $plaza->clave }}</strong> · Tipo: <strong>{{ $plaza->tipo_nombramiento }}</strong></p>
                                    </div>
                                @empty
                                    <p class="text-sm" style="color:var(--text-muted)">No se encontraron plazas registradas.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>{{-- /col central --}}

                    {{-- ── Columna derecha ── --}}
                    <div class="flex flex-col gap-4">

                        {{-- Contacto --}}
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información de contacto</h2></div>
                            <div class="card-body">
                                <div class="info-row"><span class="info-label">Calle y número:</span><span class="info-value">{{ $docente->calle_numero ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Colonia:</span><span class="info-value">{{ $docente->colonia ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Municipio:</span><span class="info-value">{{ $docente->municipio ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Estado:</span><span class="info-value">{{ $docente->estado ?? '—' }}</span></div>
                                <div class="info-row"><span class="info-label">Código postal:</span><span class="info-value">{{ $docente->codigo_postal ?? '—' }}</span></div>
                                <div class="info-row">
                                    <span class="info-label">Teléfono:</span>
                                    <span class="info-value">
                                        @if($docente->telefono)
                                            <a href="tel:{{ $docente->telefono }}" class="hover:underline" style="color:var(--brand-mid)">{{ $docente->telefono }}</a>
                                        @else —
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Correo:</span>
                                    <span class="info-value break-all">
                                        @if($docente->correo)
                                            <a href="mailto:{{ $docente->correo }}" class="hover:underline" style="color:var(--brand-mid)">{{ $docente->correo }}</a>
                                        @else —
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Nombramiento --}}
                        <div class="profile-card">
                            <div class="card-header-blue"><h2>Información del nombramiento</h2></div>
                            <div class="card-body">
                                @if($docente->nombramiento ?? null)
                                    <div class="info-row"><span class="info-label">Tipo:</span><span class="info-value">{{ $docente->nombramiento->tipo ?? '—' }}</span></div>
                                    <div class="info-row">
                                        <span class="info-label">Ingreso rama:</span>
                                        <span class="info-value">{{ isset($docente->nombramiento->ingreso_rama) ? \Carbon\Carbon::parse($docente->nombramiento->ingreso_rama)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Inicio gobierno:</span>
                                        <span class="info-value">{{ isset($docente->nombramiento->inicio_gobierno) ? \Carbon\Carbon::parse($docente->nombramiento->inicio_gobierno)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Inicio SEP:</span>
                                        <span class="info-value">{{ isset($docente->nombramiento->inicio_sep) ? \Carbon\Carbon::parse($docente->nombramiento->inicio_sep)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Inicio plantel:</span>
                                        <span class="info-value">{{ isset($docente->nombramiento->inicio_plantel) ? \Carbon\Carbon::parse($docente->nombramiento->inicio_plantel)->translatedFormat('d \d\e F \d\e Y') : '—' }}</span>
                                    </div>
                                @else
                                    <p class="text-sm" style="color:var(--text-muted)">Sin información de nombramiento.</p>
                                @endif
                            </div>
                        </div>

                    </div>{{-- /col derecha --}}

                </div>{{-- /grid perfil --}}
            </div>{{-- /panel mis-datos --}}

            {{-- ══════════════════════════════════════════════════════
                 PANEL: GRUPOS (funcional)
            ══════════════════════════════════════════════════════ --}}
            @include('docentes.partials.grupos-panel')

            {{-- ══════════════════════════════════════════════════════
                 PANEL PLACEHOLDER: Cursos
            ══════════════════════════════════════════════════════ --}}
            <div x-show="paginaActiva === 'cursos'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="p-6 lg:p-8">
                <div class="mb-6">
                    <h1 class="text-xl font-extrabold text-gray-800">Cursos</h1>
                    <p class="text-sm text-gray-400 mt-0.5">Módulo en desarrollo</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm
                            flex flex-col items-center justify-center py-20 text-center px-8">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">El módulo de <strong>Cursos</strong> aún está en desarrollo.</p>
                    <p class="text-gray-300 text-xs mt-1">Pronto estará disponible.</p>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 PANEL: PROPEDÉUTICO
            ══════════════════════════════════════════════════════ --}}
            @include('docentes.partials.propedeutico-panel')

            {{-- ══════════════════════════════════════════════════════
                 PANEL: TUTORÍAS
            ══════════════════════════════════════════════════════ --}}
            @include('docentes.partials.tutorias-panel')

            {{-- ══════════════════════════════════════════════════════
                 PANEL: OPCIONES
            ══════════════════════════════════════════════════════ --}}
            <div x-show="paginaActiva === 'opciones'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="p-6 lg:p-8">

                {{-- Breadcrumb + título --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                        <button @click="paginaActiva='inicio'" class="hover:text-purple-600 transition-colors">Inicio</button>
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                        </svg>
                        <span class="font-medium" style="color:var(--brand-dark)">Opciones</span>
                    </div>
                    <h1 class="text-xl font-extrabold" style="color:var(--brand-dark)">Opciones</h1>
                </div>

                {{-- Layout: submenú izquierdo | contenido derecho --}}
                <div class="flex gap-5 items-start"
                     x-data="{
                         actual:     '',
                         nueva:      '',
                         repite:     '',
                         showActual: false,
                         showNueva:  false,
                         showRepite: false,
                         get minLen()   { return this.nueva.length >= 8 },
                         get hasNum()   { return /[0-9]/.test(this.nueva) },
                         get hasEsp()   { return /[^A-Za-z0-9]/.test(this.nueva) },
                         get coincide() { return this.nueva.length > 0 && this.nueva === this.repite }
                     }">

                    {{-- ── Submenú lateral ── --}}
                    <div class="w-52 flex-shrink-0">
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mi cuenta</p>
                            </div>
                            <nav class="p-2 space-y-0.5">

                                {{-- Cambiar contraseña --}}
                                <button @click="opcionSubActiva = 'cambiar'"
                                        :class="opcionSubActiva === 'cambiar'
                                            ? 'bg-purple-50 text-purple-700 font-semibold'
                                            : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                                        class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-left transition-colors">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    <span class="whitespace-nowrap">Cambiar contraseña</span>
                                </button>

                                {{-- Cerrar sesión --}}
                                <button @click="opcionSubActiva = 'cerrar'"
                                        :class="opcionSubActiva === 'cerrar'
                                            ? 'bg-red-50 text-red-600 font-semibold'
                                            : 'text-gray-500 hover:bg-red-50 hover:text-red-500'"
                                        class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-left transition-colors">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="whitespace-nowrap">Cerrar sesión</span>
                                </button>

                            </nav>
                        </div>
                    </div>{{-- /submenú --}}

                    {{-- ── Área de contenido ── --}}
                    <div class="flex-1 min-w-0">

                        {{-- ·· SUBPANEL: Cambiar contraseña ·· --}}
                        <div x-show="opcionSubActiva === 'cambiar'"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-x-1"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-xl">

                                <div class="px-6 pt-5 pb-4 border-b border-slate-100">
                                    <h2 class="text-base font-bold" style="color:var(--brand-dark)">Cambiar contraseña</h2>
                                </div>

                                <div class="mx-6 mt-4 mb-1 px-4 py-2.5 rounded-lg"
                                     style="background:var(--brand-pale); border:1px solid var(--card-border)">
                                    <p class="text-xs font-semibold" style="color:var(--brand-mid)">
                                        Los campos con <span style="color:#e53e3e">*</span> son obligatorios
                                    </p>
                                    <p class="text-xs mt-0.5" style="color:var(--text-muted)">
                                        La nueva contraseña debe tener <strong>mínimo 8 caracteres</strong>,
                                        <strong>1 número</strong> y <strong>1 carácter especial</strong>.
                                    </p>
                                </div>

                                <form method="POST"
                                      action="{{ route('docentes.cambiar-contrasena.guardar') }}"
                                      class="px-6 pt-4 pb-6">
                                    @csrf

                                    {{-- Contraseña actual --}}
                                    <div class="pass-group">
                                        <label class="pass-label" for="password_actual">Contraseña actual<span>*</span></label>
                                        <div class="pass-wrapper">
                                            <input id="password_actual"
                                                   :type="showActual ? 'text' : 'password'"
                                                   name="password_actual"
                                                   x-model="actual"
                                                   autocomplete="current-password"
                                                   class="pass-input {{ $errors->has('password_actual') ? 'is-error' : '' }}"
                                                   placeholder="Tu contraseña actual"
                                                   required>
                                            <button type="button" class="pass-toggle"
                                                    @click="showActual = !showActual"
                                                    :title="showActual ? 'Ocultar' : 'Mostrar'">
                                                <svg x-show="!showActual" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <svg x-show="showActual" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password_actual')
                                            <p class="field-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Contraseña nueva --}}
                                    <div class="pass-group">
                                        <label class="pass-label" for="password_nueva">Contraseña nueva<span>*</span></label>
                                        <div class="pass-wrapper">
                                            <input id="password_nueva"
                                                   :type="showNueva ? 'text' : 'password'"
                                                   name="password_nueva"
                                                   x-model="nueva"
                                                   autocomplete="new-password"
                                                   class="pass-input {{ $errors->has('password_nueva') ? 'is-error' : '' }}"
                                                   placeholder="Mínimo 8 caracteres"
                                                   required>
                                            <button type="button" class="pass-toggle" @click="showNueva = !showNueva">
                                                <svg x-show="!showNueva" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <svg x-show="showNueva" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <ul class="req-list">
                                            <li class="req-item" :class="{ ok: minLen }"><span class="dot"></span>8 caracteres mínimo</li>
                                            <li class="req-item" :class="{ ok: hasNum }"><span class="dot"></span>Al menos 1 número</li>
                                            <li class="req-item" :class="{ ok: hasEsp }"><span class="dot"></span>Al menos 1 carácter especial</li>
                                        </ul>
                                        @error('password_nueva')
                                            <p class="field-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Repetir contraseña --}}
                                    <div class="pass-group">
                                        <label class="pass-label" for="password_nueva_confirmation">Repite la contraseña nueva<span>*</span></label>
                                        <div class="pass-wrapper">
                                            <input id="password_nueva_confirmation"
                                                   :type="showRepite ? 'text' : 'password'"
                                                   name="password_nueva_confirmation"
                                                   x-model="repite"
                                                   autocomplete="new-password"
                                                   :class="repite.length > 0 && !coincide ? 'pass-input is-error' : 'pass-input'"
                                                   placeholder="Repite la nueva contraseña"
                                                   required>
                                            <button type="button" class="pass-toggle" @click="showRepite = !showRepite">
                                                <svg x-show="!showRepite" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <svg x-show="showRepite" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <p x-show="repite.length > 0 && !coincide" class="field-error" x-transition>
                                            Las contraseñas no coinciden.
                                        </p>
                                        @error('password_nueva_confirmation')
                                            <p class="field-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end mt-2">
                                        <button type="submit"
                                                :disabled="!minLen || !hasNum || !hasEsp || !coincide || actual.length === 0"
                                                class="btn-cambiar disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Cambiar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>{{-- /subpanel cambiar --}}

                        {{-- ·· SUBPANEL: Cerrar sesión ·· --}}
                        <div x-show="opcionSubActiva === 'cerrar'"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-x-1"
                             x-transition:enter-end="opacity-100 translate-x-0">

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-xl">

                                <div class="px-6 pt-5 pb-4 border-b border-slate-100">
                                    <h2 class="text-base font-bold text-red-600">Cerrar sesión</h2>
                                </div>

                                <div class="px-6 py-8 flex flex-col items-center text-center gap-5">
                                    <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 font-semibold text-sm">¿Deseas cerrar tu sesión?</p>
                                        <p class="text-gray-400 text-xs mt-1">
                                            Se cerrará la sesión de <strong>{{ $fullName }}</strong> y serás redirigido al inicio de sesión.
                                        </p>
                                    </div>
                                    <div class="flex gap-3">
                                        <button @click="opcionSubActiva = 'cambiar'"
                                                type="button"
                                                class="px-4 py-2 rounded-xl text-sm font-semibold border border-slate-200
                                                       text-gray-500 hover:bg-slate-50 transition-colors">
                                            Cancelar
                                        </button>
                                        <form method="POST" action="{{ route('docente.logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="px-5 py-2 rounded-xl text-sm font-bold bg-red-600 text-white
                                                           hover:bg-red-700 transition-colors shadow-sm">
                                                Sí, cerrar sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>{{-- /subpanel cerrar --}}

                    </div>{{-- /área de contenido --}}

                </div>{{-- /flex submenú + contenido --}}

            </div>{{-- /panel opciones --}}

        </main>

        {{-- Toast global --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition
             class="fixed bottom-6 right-6 z-50 bg-green-600 text-white text-sm font-semibold
                    px-5 py-3 rounded-xl shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif
    </div>{{-- /área principal --}}

</div>{{-- /layout raíz --}}

</body>
</html>
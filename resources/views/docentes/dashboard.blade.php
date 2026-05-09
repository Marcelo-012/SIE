<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans antialiased">

{{-- ================================================================
     LAYOUT RAÍZ — Alpine.js controla la apertura del sidebar
================================================================ --}}
<div class="flex h-screen overflow-hidden"
     x-data="{ sidebarOpen: true, paginaActiva: 'inicio' }">

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

        {{-- Navegación principal --}}
        <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">

            {{-- Item: Inicio --}}
            <button @click="paginaActiva = 'inicio'"
                    :class="paginaActiva === 'inicio'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="whitespace-nowrap">Inicio</span>
                <template x-if="paginaActiva === 'inicio'">
                    <div class="ml-auto w-1.5 h-1.5 bg-purple-600 rounded-full"></div>
                </template>
            </button>

            {{-- Item: Cursos --}}
            <button @click="paginaActiva = 'cursos'"
                    :class="paginaActiva === 'cursos'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="whitespace-nowrap">Cursos</span>
            </button>

            {{-- Item: Grupos --}}
            <button @click="paginaActiva = 'grupos'"
                    :class="paginaActiva === 'grupos'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="whitespace-nowrap">Grupos</span>
            </button>

            {{-- Item: Propedéutico --}}
            <button @click="paginaActiva = 'propedeutico'"
                    :class="paginaActiva === 'propedeutico'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <span class="whitespace-nowrap">Propedéutico</span>
            </button>

            {{-- Item: Tutorías --}}
            <button @click="paginaActiva = 'tutorias'"
                    :class="paginaActiva === 'tutorias'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="whitespace-nowrap">Tutorías</span>
            </button>

            {{-- Separador --}}
            <div class="my-2 border-t border-slate-100"></div>

            {{-- Item: Mis datos --}}
            <button @click="paginaActiva = 'mis-datos'"
                    :class="paginaActiva === 'mis-datos'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="whitespace-nowrap">Mis datos</span>
            </button>

            {{-- Item: Opciones --}}
            <button @click="paginaActiva = 'opciones'"
                    :class="paginaActiva === 'opciones'
                        ? 'bg-purple-50 text-purple-700 font-semibold'
                        : 'text-gray-500 hover:bg-slate-50 hover:text-gray-700'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="whitespace-nowrap">Opciones</span>
            </button>
        </nav>

        {{-- Botón: Ocultar menú --}}
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
         ÁREA PRINCIPAL (Header + Contenido)
    ============================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <header class="bg-white border-b border-slate-100 flex items-center px-6 py-3 gap-4 flex-shrink-0">

            {{-- Botón para mostrar sidebar (cuando está oculto) --}}
            <button x-show="!sidebarOpen"
                    @click="sidebarOpen = true"
                    class="p-2 rounded-lg text-gray-400 hover:bg-slate-50 hover:text-gray-600
                           transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo del Instituto Tecnológico de Pinotepa (centrado) --}}
            <div class="flex-1 flex items-center justify-center gap-3">
                {{-- Escudo / Logo institucional --}}
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-700 to-red-900
                            rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-400 uppercase tracking-widest leading-none mb-0.5">
                        Instituto Tecnológico de
                    </p>
                    <p class="text-sm font-bold text-gray-800 tracking-wide uppercase leading-none">
                        Pinotepa
                    </p>
                </div>
            </div>

            {{-- Nombre del docente + Avatar --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Edgar Luis Garcia Vargas</p>
                    <p class="text-xs text-gray-400">Docente</p>
                </div>
                {{-- Avatar con iniciales --}}
                <div class="w-9 h-9 bg-gradient-to-br from-purple-600 to-indigo-700 rounded-full
                            flex items-center justify-center flex-shrink-0 shadow-sm cursor-pointer
                            hover:opacity-90 transition-opacity">
                    <span class="text-white text-xs font-bold">EG</span>
                </div>
            </div>
        </header>

        {{-- ── CONTENIDO PRINCIPAL ─────────────────────────────────── --}}
        <main class="flex-1 overflow-y-auto bg-slate-100 p-6 lg:p-8">

            {{-- Título de bienvenida --}}
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight uppercase">
                    ¡Bienvenido EDGAR LUIS!
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>

            {{-- ── Grid de tarjetas 2×2 ──────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

                {{-- Tarjeta: Cursos --}}
                <a href="#" class="group bg-blue-50 hover:bg-blue-100 border border-blue-100
                                   rounded-2xl p-5 flex items-center gap-4 transition-all
                                   hover:shadow-md hover:border-blue-200 active:scale-[0.98]">
                    {{-- Ícono de categoría --}}
                    <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl
                                flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    {{-- Texto --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-base">Cursos</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">Gestiona tus materias asignadas</p>
                    </div>
                    {{-- Ícono de flecha circular (gradiente azul-morado) --}}
                    <div class="w-10 h-10 flex-shrink-0">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <defs>
                                <linearGradient id="grad-cursos" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#38bdf8"/>
                                    <stop offset="100%" style="stop-color:#a855f7"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#grad-cursos)"
                                  d="M50,5 A45,45 0 1,1 5,50 A45,45 0 0,1 50,5 Z
                                     M50,18 A32,32 0 1,0 82,50 A32,32 0 0,0 50,18 Z"/>
                            <polygon fill="url(#grad-cursos)" points="50,2 58,20 42,20"/>
                            <polygon fill="url(#grad-cursos)" points="98,50 80,42 80,58"/>
                        </svg>
                    </div>
                </a>

                {{-- Tarjeta: Mis datos --}}
                <a href="#" class="group bg-blue-50 hover:bg-blue-100 border border-blue-100
                                   rounded-2xl p-5 flex items-center gap-4 transition-all
                                   hover:shadow-md hover:border-blue-200 active:scale-[0.98]">
                    <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl
                                flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 2 1.5 3 3 3s3-1 3-3"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-base">Mis datos</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">Información personal y académica</p>
                    </div>
                    <div class="w-10 h-10 flex-shrink-0">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <defs>
                                <linearGradient id="grad-datos" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#38bdf8"/>
                                    <stop offset="100%" style="stop-color:#a855f7"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#grad-datos)"
                                  d="M50,5 A45,45 0 1,1 5,50 A45,45 0 0,1 50,5 Z
                                     M50,18 A32,32 0 1,0 82,50 A32,32 0 0,0 50,18 Z"/>
                            <polygon fill="url(#grad-datos)" points="50,2 58,20 42,20"/>
                            <polygon fill="url(#grad-datos)" points="98,50 80,42 80,58"/>
                        </svg>
                    </div>
                </a>

                {{-- Tarjeta: Propedéutico --}}
                <a href="#" class="group bg-blue-50 hover:bg-blue-100 border border-blue-100
                                   rounded-2xl p-5 flex items-center gap-4 transition-all
                                   hover:shadow-md hover:border-blue-200 active:scale-[0.98]">
                    <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl
                                flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-base">Propedéutico</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">Módulo de seguimiento propedéutico</p>
                    </div>
                    <div class="w-10 h-10 flex-shrink-0">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <defs>
                                <linearGradient id="grad-prope" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#38bdf8"/>
                                    <stop offset="100%" style="stop-color:#a855f7"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#grad-prope)"
                                  d="M50,5 A45,45 0 1,1 5,50 A45,45 0 0,1 50,5 Z
                                     M50,18 A32,32 0 1,0 82,50 A32,32 0 0,0 50,18 Z"/>
                            <polygon fill="url(#grad-prope)" points="50,2 58,20 42,20"/>
                            <polygon fill="url(#grad-prope)" points="98,50 80,42 80,58"/>
                        </svg>
                    </div>
                </a>

                {{-- Tarjeta: Tutorías --}}
                <a href="#" class="group bg-blue-50 hover:bg-blue-100 border border-blue-100
                                   rounded-2xl p-5 flex items-center gap-4 transition-all
                                   hover:shadow-md hover:border-blue-200 active:scale-[0.98]">
                    <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl
                                flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-base">Tutorías</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">Seguimiento a alumnos tutorados</p>
                    </div>
                    <div class="w-10 h-10 flex-shrink-0">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <defs>
                                <linearGradient id="grad-tutorias" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#38bdf8"/>
                                    <stop offset="100%" style="stop-color:#a855f7"/>
                                </linearGradient>
                            </defs>
                            <path fill="url(#grad-tutorias)"
                                  d="M50,5 A45,45 0 1,1 5,50 A45,45 0 0,1 50,5 Z
                                     M50,18 A32,32 0 1,0 82,50 A32,32 0 0,0 50,18 Z"/>
                            <polygon fill="url(#grad-tutorias)" points="50,2 58,20 42,20"/>
                            <polygon fill="url(#grad-tutorias)" points="98,50 80,42 80,58"/>
                        </svg>
                    </div>
                </a>

            </div>{{-- /grid tarjetas --}}

            {{-- ── Sección Avisos ────────────────────────────────── --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-gray-700 uppercase tracking-wide">Avisos</h2>
                    <span class="text-xs text-gray-400">{{ now()->format('d/m/Y') }}</span>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                    {{-- Estado vacío --}}
                    <div class="flex flex-col items-center justify-center py-14 px-8 text-center">
                        {{-- Ícono decorativo --}}
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm font-medium">
                            Al parecer no tienes nada importante que ver por aquí...
                        </p>
                        <p class="text-gray-300 text-xs mt-1">
                            Los avisos del coordinador aparecerán en este espacio.
                        </p>
                    </div>
                </div>
            </div>

        </main>{{-- /main --}}
    </div>{{-- /área principal --}}

</div>{{-- /layout raíz --}}

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

{{-- ================================================================
     LAYOUT RAÍZ
================================================================ --}}
<div class="flex h-screen overflow-hidden"
     x-data="{ sidebarOpen: true, paginaActiva: 'inicio' }">

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside :class="sidebarOpen ? 'w-56' : 'w-0 overflow-hidden'"
           class="flex-shrink-0 bg-white border-r border-slate-200 flex flex-col
                  transition-all duration-300 ease-in-out select-none">

        {{-- Logo MindBox --}}
        <div class="flex items-center gap-2 px-5 pt-5 pb-4">
            {{-- Icono cuadrado redondeado azul-morado --}}
            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm0 2.28L18.82 9
                             12 12.72 5.18 9 12 5.28zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>
            <span class="font-extrabold text-indigo-700 text-base tracking-tight whitespace-nowrap">
                MindBox<sup class="text-[9px] font-bold">®</sup>
            </span>
        </div>

        {{-- Buscador --}}
        <div class="px-4 mb-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
                <input type="search"
                       placeholder="Buscar en el menú..."
                       class="w-full pl-8 pr-3 py-2 bg-slate-100 border-0 rounded-lg
                              text-xs text-slate-600 placeholder-slate-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:bg-white
                              transition-colors">
            </div>
        </div>

        {{-- Separador --}}
        <div class="mx-4 mb-1 border-t border-slate-100"></div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 py-1 space-y-0.5 overflow-y-auto">

            {{-- Inicio --}}
            <button @click="paginaActiva = 'inicio'"
                    :class="paginaActiva === 'inicio'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504
                             1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504
                             1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span class="whitespace-nowrap">Inicio</span>
            </button>

            {{-- En curso --}}
            <button @click="paginaActiva = 'en-curso'"
                    :class="paginaActiva === 'en-curso'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115
                             18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013
                             15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3"/>
                </svg>
                <span class="whitespace-nowrap">En curso</span>
            </button>

            {{-- Mis datos --}}
            <button @click="paginaActiva = 'mis-datos'"
                    :class="paginaActiva === 'mis-datos'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5
                             7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676
                             0-5.216-.584-7.499-1.632z"/>
                </svg>
                <span class="whitespace-nowrap">Mis datos</span>
            </button>

            {{-- Histórico --}}
            <button @click="paginaActiva = 'historico'"
                    :class="paginaActiva === 'historico'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="whitespace-nowrap">Histórico</span>
            </button>

            {{-- Inscripciones --}}
            <button @click="paginaActiva = 'inscripciones'"
                    :class="paginaActiva === 'inscripciones'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993
                             0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0
                             0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                <span class="whitespace-nowrap">Inscripciones</span>
            </button>

            {{-- Evaluaciones --}}
            <button @click="paginaActiva = 'evaluaciones'"
                    :class="paginaActiva === 'evaluaciones'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424
                             48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0
                             00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0
                             1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973
                             8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125
                             1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
                <span class="whitespace-nowrap">Evaluaciones</span>
            </button>

            {{-- Pagos --}}
            <button @click="paginaActiva = 'pagos'"
                    :class="paginaActiva === 'pagos'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25
                             0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0
                             016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25
                             2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0
                             0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5
                             15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0
                             0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                </svg>
                <span class="whitespace-nowrap">Pagos</span>
            </button>

            {{-- Constancias --}}
            <button @click="paginaActiva = 'constancias'"
                    :class="paginaActiva === 'constancias'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5
                             4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0
                             0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013
                             18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                </svg>
                <span class="whitespace-nowrap">Constancias</span>
            </button>

            {{-- Opciones --}}
            <button @click="paginaActiva = 'opciones'"
                    :class="paginaActiva === 'opciones'
                        ? 'text-indigo-600 font-semibold'
                        : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors text-left">
                <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75
                             6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75
                             0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                </svg>
                <span class="whitespace-nowrap">Opciones</span>
            </button>

            {{-- Ocultar menú --}}
            <div class="pt-1 border-t border-slate-100 mt-1">
                <button @click="sidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm
                               text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors text-left">
                    <svg class="w-5 h-5 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    <span class="whitespace-nowrap">Ocultar menú</span>
                </button>
            </div>
        </nav>

        {{-- Footer sidebar --}}
        <div class="px-5 py-3 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 leading-snug text-center">
                MindBox<sup class="text-[8px]">®</sup><br>
                Todos los derechos reservados © {{ date('Y') }}.
            </p>
        </div>
    </aside>

    {{-- ============================================================
         ÁREA PRINCIPAL
    ============================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <header class="bg-white border-b border-slate-200 flex items-center px-6 py-3 gap-4 flex-shrink-0">

            {{-- Botón hamburger (visible cuando sidebar oculto) --}}
            <button x-show="!sidebarOpen"
                    @click="sidebarOpen = true"
                    class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-slate-600
                           transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo + nombre del instituto (alineado a la izquierda) --}}
            <div class="flex items-center gap-3 flex-1 min-w-0">
                {{-- Escudo institucional --}}
                <div class="flex-shrink-0 w-9 h-9 rounded-full overflow-hidden
                            bg-gradient-to-br from-green-700 to-yellow-600
                            flex items-center justify-center shadow-sm border-2 border-white ring-1 ring-slate-200">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm0 2.28L18.82
                                 9 12 12.72 5.18 9 12 5.28zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-700 truncate">
                    Instituto Tecnológico de Pinotepa
                </span>
            </div>

            {{-- Nombre del alumno + avatar --}}
            <div class="flex items-center gap-2.5 flex-shrink-0">
                {{-- Avatar person icon --}}
                <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12
                                 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                <span class="text-sm text-slate-700 hidden sm:block">Marcelo Emmanuel Rivero Martinez</span>
                {{-- Dropdown arrow --}}
                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </header>

        {{-- ── CONTENIDO PRINCIPAL ─────────────────────────────────── --}}
        <main class="flex-1 overflow-y-auto bg-slate-50 px-10 py-8">

            {{-- Bienvenida --}}
            <div class="mb-6">
                <p class="text-sm text-slate-500 mb-0.5">¡Bienvenido</p>
                <h1 class="text-3xl font-extrabold text-slate-800 uppercase tracking-tight leading-none">
                    MARCELO EMMANUEL!
                </h1>
            </div>

            {{-- ── Grid de tarjetas de acción ──────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-7 max-w-3xl">

                {{-- Mis cursos --}}
                <a href="#"
                   class="flex items-center justify-between px-5 py-3.5 rounded-lg
                          bg-indigo-50 hover:bg-indigo-100 border border-indigo-100/80
                          transition-all hover:border-indigo-200 active:scale-[0.99] group">
                    <span class="text-sm font-medium text-indigo-700">Mis cursos</span>
                    {{-- Icono círculo con flecha --}}
                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-indigo-600 transition-colors flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>

                {{-- Mis datos --}}
                <a href="#"
                   class="flex items-center justify-between px-5 py-3.5 rounded-lg
                          bg-indigo-50 hover:bg-indigo-100 border border-indigo-100/80
                          transition-all hover:border-indigo-200 active:scale-[0.99] group">
                    <span class="text-sm font-medium text-indigo-700">Mis datos</span>
                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-indigo-600 transition-colors flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>

                {{-- Pagos --}}
                <a href="#"
                   class="flex items-center justify-between px-5 py-3.5 rounded-lg
                          bg-indigo-50 hover:bg-indigo-100 border border-indigo-100/80
                          transition-all hover:border-indigo-200 active:scale-[0.99] group">
                    <span class="text-sm font-medium text-indigo-700">Pagos</span>
                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-indigo-600 transition-colors flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>

                {{-- Boletas --}}
                <a href="#"
                   class="flex items-center justify-between px-5 py-3.5 rounded-lg
                          bg-indigo-50 hover:bg-indigo-100 border border-indigo-100/80
                          transition-all hover:border-indigo-200 active:scale-[0.99] group">
                    <span class="text-sm font-medium text-indigo-700">Boletas</span>
                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-indigo-600 transition-colors flex-shrink-0"
                         fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>

            </div>{{-- /grid --}}

            {{-- ── Sección Avisos ───────────────────────────────────── --}}
            <div class="max-w-3xl">
                <h2 class="text-sm font-semibold text-slate-700 mb-3">Avisos</h2>

                <div class="bg-white border border-slate-200 rounded-lg px-5 py-4">
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Al parecer no tienes nada importante que ver por aquí.
                        Podrás ver información importante cuando sea publicada por tu escuela.
                    </p>
                </div>
            </div>

        </main>{{-- /main --}}
    </div>{{-- /área principal --}}

</div>{{-- /layout raíz --}}

</body>
</html>

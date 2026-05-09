<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — {{ config('app.name', 'Sistema Escolar') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans antialiased">

    {{-- ================================================================
         CARD PRINCIPAL: flex-row, dos columnas
    ================================================================ --}}
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex min-h-[580px]"
         x-data="{
             rol: 'estudiante',
             labelIdentificador() {
                 const labels = {
                     estudiante: 'Número de control',
                     personal:   'Número de empleado',
                     aspirante:  'CURP o Folio de aspirante',
                 };
                 return labels[this.rol];
             },
             placeholderIdentificador() {
                 const ph = {
                     estudiante: 'Ej. 22100001',
                     personal:   'Ej. DOC-0001',
                     aspirante:  'Ej. XXXX000000XXXXXX00',
                 };
                 return ph[this.rol];
             }
         }">

        {{-- ============================================================
             COLUMNA IZQUIERDA — Visual / Branding (oculta en móvil)
        ============================================================ --}}
        <div class="hidden md:flex md:w-2/5 bg-gradient-to-br from-purple-700 via-purple-800 to-indigo-900
                    flex-col items-center justify-between p-8 relative overflow-hidden select-none">

            {{-- Esferas decorativas de fondo --}}
            <div class="absolute -top-12 -right-12 w-56 h-56 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/3 -left-16 w-40 h-40 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>

            {{-- Logo MindBox --}}
            <div class="w-full flex items-center gap-2.5 z-10">
                <div class="bg-white/20 rounded-xl p-2 backdrop-blur-sm border border-white/10">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">MindBox</span>
            </div>

            {{-- Imagen central con iconos flotantes --}}
            <div class="relative flex items-center justify-center w-full z-10 my-4">

                {{-- Avatar / Persona con audífonos (placeholder SVG) --}}
                <div class="w-44 h-44 bg-white/15 rounded-full flex items-center justify-center
                            border-4 border-white/25 shadow-2xl backdrop-blur-sm">
                    <svg class="w-28 h-28 text-white/70" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>

                {{-- Auriculares decorativos (arco superior) --}}
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-10
                            border-4 border-white/30 rounded-t-full"></div>

                {{-- Icono flotante: Calendario --}}
                <div class="absolute -top-4 -left-2 bg-white rounded-2xl p-2.5 shadow-xl
                            transform -rotate-6 hover:rotate-0 transition-transform">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                {{-- Icono flotante: Campana --}}
                <div class="absolute -top-6 right-2 bg-amber-400 rounded-2xl p-2.5 shadow-xl
                            transform rotate-6 hover:rotate-0 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>

                {{-- Icono flotante: Credencial / ID --}}
                <div class="absolute bottom-0 -right-3 bg-white rounded-2xl p-2.5 shadow-xl
                            transform rotate-3 hover:rotate-0 transition-transform">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 2 1.5 3 3 3s3-1 3-3"/>
                    </svg>
                </div>

                {{-- Mini badge flotante --}}
                <div class="absolute -bottom-1 -left-4 bg-white/20 backdrop-blur-sm rounded-xl
                            px-3 py-1.5 border border-white/30 shadow-lg">
                    <p class="text-white text-xs font-semibold">📚 245 materias activas</p>
                </div>
            </div>

            {{-- Cita inspiracional --}}
            <div class="z-10 text-center px-2">
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex-1 h-px bg-white/25"></div>
                    <svg class="w-4 h-4 text-white/40 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                    </svg>
                    <div class="flex-1 h-px bg-white/25"></div>
                </div>
                <p class="text-white/85 text-sm font-light italic leading-relaxed">
                    "La educación es el arma más poderosa que puedes usar para cambiar el mundo."
                </p>
                <p class="text-white/50 text-xs mt-2 tracking-widest uppercase font-medium">— Nelson Mandela</p>
            </div>
        </div>

        {{-- ============================================================
             COLUMNA DERECHA — Formulario
        ============================================================ --}}
        <div class="w-full md:w-3/5 bg-white flex flex-col items-center justify-center
                    px-8 py-10 lg:px-14">

            {{-- Logo institucional --}}
            <div class="flex flex-col items-center mb-7">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl
                            flex items-center justify-center mb-3 shadow-sm">
                    <svg class="w-9 h-9 text-purple-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-800 tracking-tight">
                    {{ config('app.name', 'Sistema Escolar') }}
                </h1>
                <p class="text-gray-400 text-sm mt-0.5">Plataforma educativa institucional</p>
            </div>

            {{-- Mensaje de sesión (status) --}}
            <x-auth-session-status class="mb-4 w-full" :status="session('status')" />

            {{-- ── Tab Switcher de Roles ── --}}
            <div class="w-full mb-6" role="tablist" aria-label="Tipo de usuario">
                <div class="flex bg-slate-100 rounded-xl p-1 gap-1">
                    <button type="button" role="tab"
                            :aria-selected="rol === 'estudiante'"
                            @click="rol = 'estudiante'"
                            :class="rol === 'estudiante'
                                ? 'bg-purple-700 text-white shadow-sm'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-white/50'"
                            class="flex-1 py-2 px-2 rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500">
                        Estudiantes
                    </button>
                    <button type="button" role="tab"
                            :aria-selected="rol === 'personal'"
                            @click="rol = 'personal'"
                            :class="rol === 'personal'
                                ? 'bg-purple-700 text-white shadow-sm'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-white/50'"
                            class="flex-1 py-2 px-2 rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500">
                        Personal
                    </button>
                    <button type="button" role="tab"
                            :aria-selected="rol === 'aspirante'"
                            @click="rol = 'aspirante'"
                            :class="rol === 'aspirante'
                                ? 'bg-purple-700 text-white shadow-sm'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-white/50'"
                            class="flex-1 py-2 px-2 rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500">
                        Aspirantes
                    </button>
                </div>
            </div>

            {{-- ── Formulario de Login ── --}}
            <form method="POST" action="{{ route('login') }}" class="w-full space-y-4" novalidate>
                @csrf
                {{-- Rol seleccionado (oculto) --}}
                <input type="hidden" name="rol" :value="rol">

                {{-- Campo: Identificador (dinámico según rol) --}}
                <div>
                    <label for="identificador"
                           class="block text-sm font-medium text-gray-700 mb-1.5"
                           x-text="labelIdentificador()">
                        Número de control
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <x-text-input
                            id="identificador"
                            name="identificador"
                            type="text"
                            :placeholder="''"
                            x-bind:placeholder="placeholderIdentificador()"
                            class="block w-full pl-10 !bg-indigo-50/60 !border-indigo-100
                                   focus:!bg-white focus:!border-purple-500 focus:!ring-purple-500
                                   !rounded-xl !shadow-none transition-colors"
                            :value="old('identificador')"
                            required
                            autofocus
                            autocomplete="username"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('identificador')" class="mt-1.5" />
                </div>

                {{-- Campo: Contraseña --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Contraseña
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-purple-600 hover:text-purple-800 font-medium
                                      hover:underline underline-offset-2 transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            class="block w-full pl-10 !bg-indigo-50/60 !border-indigo-100
                                   focus:!bg-white focus:!border-purple-500 focus:!ring-purple-500
                                   !rounded-xl !shadow-none transition-colors"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                {{-- Recordar sesión --}}
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-purple-600
                                  focus:ring-purple-500 focus:ring-offset-0 transition-colors">
                    <label for="remember_me" class="ml-2 text-sm text-gray-500 cursor-pointer select-none">
                        Recordar mi sesión
                    </label>
                </div>

                {{-- Botón de envío --}}
                <button type="submit"
                        class="w-full bg-purple-700 hover:bg-purple-800 active:bg-purple-900
                               text-white font-semibold py-3 px-4 rounded-xl
                               transition-all duration-200
                               shadow-md hover:shadow-purple-300/50 hover:shadow-lg
                               flex items-center justify-center gap-2
                               focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2
                               disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Iniciar sesión
                </button>
            </form>

            {{-- Footer --}}
            <p class="text-xs text-gray-300 mt-8 text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </p>
        </div>

    </div>

</body>
</html>

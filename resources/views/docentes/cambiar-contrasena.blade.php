{{-- resources/views/docentes/perfil/cambiar-contrasena.blade.php --}}

@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@push('styles')
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

    /* ── Campo de contraseña ────────────────────────────────────── */
    .pass-group { margin-bottom: 1.1rem; }
    .pass-label {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: .35rem;
    }
    .pass-label span { color: #e53e3e; margin-left: 1px; }

    .pass-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .pass-input {
        width: 100%;
        border: 1.5px solid #cbd5e1;
        border-radius: .55rem;
        padding: .6rem .9rem;
        padding-right: 2.6rem;
        font-size: .88rem;
        color: var(--text-primary);
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .pass-input:focus {
        border-color: var(--brand-mid);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .pass-input.is-error { border-color: #e53e3e; box-shadow: 0 0 0 3px rgba(229,62,62,.1); }

    /* Ojo mostrar/ocultar */
    .pass-toggle {
        position: absolute;
        right: .7rem;
        color: #94a3b8;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color .15s;
    }
    .pass-toggle:hover { color: var(--brand-mid); }

    /* ── Requisitos de contraseña ───────────────────────────────── */
    .req-list { list-style: none; padding: 0; margin: .5rem 0 0; display: flex; flex-wrap: wrap; gap: .3rem .9rem; }
    .req-item {
        font-size: .72rem; color: var(--text-muted);
        display: flex; align-items: center; gap: .3rem;
    }
    .req-item .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #cbd5e1; flex-shrink: 0; transition: background .2s;
    }
    .req-item.ok .dot { background: #16a34a; }
    .req-item.ok    { color: #16a34a; }

    /* ── Botón Cambiar ──────────────────────────────────────────── */
    .btn-cambiar {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.4rem; border-radius: .55rem;
        background: var(--brand-dark); color: #fff;
        font-size: .85rem; font-weight: 700;
        border: none; cursor: pointer; outline: none;
        transition: background .15s, box-shadow .15s;
    }
    .btn-cambiar:hover {
        background: #162d4a;
        box-shadow: 0 3px 10px rgba(30,58,95,.3);
    }
    .btn-cambiar:active { transform: scale(.98); }

    /* ── Error message under input ──────────────────────────────── */
    .field-error { font-size: .72rem; color: #e53e3e; margin-top: .25rem; }
</style>
@endpush

@section('content')

<div class="px-4 sm:px-6 pb-10 max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-xs text-gray-400 pt-4 mb-5">
        <a href="{{ route('docente.dashboard') }}"
           class="hover:text-blue-600 transition-colors">Inicio</a>
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
        </svg>
        <span class="font-medium" style="color:var(--brand-dark)">Cambiar contraseña</span>
    </div>

    {{-- ============================================================
         TARJETA PRINCIPAL
    ============================================================ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
         x-data="{
             actual:    '',
             nueva:     '',
             repite:    '',
             showActual:  false,
             showNueva:   false,
             showRepite:  false,
             get minLen()    { return this.nueva.length >= 8 },
             get hasNum()    { return /[0-9]/.test(this.nueva) },
             get hasEsp()    { return /[^A-Za-z0-9]/.test(this.nueva) },
             get coincide()  { return this.nueva.length > 0 && this.nueva === this.repite }
         }">

        {{-- ── Cabecera azul oscuro ──────────────────────────────── --}}
        <div class="px-6 pt-5 pb-4">
            <h1 class="text-lg font-bold" style="color:var(--brand-dark)">Cambiar contraseña</h1>
        </div>

        {{-- ── Aviso de campos obligatorios ─────────────────────── --}}
        <div class="mx-6 mb-1 px-4 py-2.5 rounded-lg"
             style="background:var(--brand-pale); border:1px solid var(--card-border)">
            <p class="text-xs font-semibold" style="color:var(--brand-mid)">
                Los campos con <span style="color:#e53e3e">*</span> son obligatorios
            </p>
            <p class="text-xs mt-0.5" style="color:var(--text-muted)">
                En seguida podrás cambiar tu contraseña actual del sistema, recuerda que debe tener
                <strong>8 caracteres como mínimo</strong>, <strong>1 número</strong> y
                <strong>1 carácter especial</strong>.
            </p>
        </div>

        {{-- ── Formulario ───────────────────────────────────────── --}}
        {{-- Ruta necesaria: POST /docente/cambiar-contrasena → DocenteController@cambiarContrasena --}}
        <form method="POST" action="{{ route('docentes.cambiar-contrasena.guardar') }}"
              class="px-6 pt-4 pb-6">
            @csrf

            {{-- Contraseña actual --}}
            <div class="pass-group">
                <label class="pass-label" for="password_actual">
                    Contraseña actual<span>*</span>
                </label>
                <div class="pass-wrapper">
                    <input id="password_actual"
                           :type="showActual ? 'text' : 'password'"
                           name="password_actual"
                           x-model="actual"
                           autocomplete="current-password"
                           class="pass-input {{ $errors->has('password_actual') ? 'is-error' : '' }}"
                           placeholder="Ingresa tu contraseña actual"
                           required>
                    <button type="button" class="pass-toggle"
                            @click="showActual = !showActual"
                            :title="showActual ? 'Ocultar' : 'Mostrar'">
                        <svg x-show="!showActual" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showActual" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7
                                     a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243
                                     M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29
                                     M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7
                                     a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password_actual')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseña nueva --}}
            <div class="pass-group">
                <label class="pass-label" for="password_nueva">
                    Contraseña nueva<span>*</span>
                </label>
                <div class="pass-wrapper">
                    <input id="password_nueva"
                           :type="showNueva ? 'text' : 'password'"
                           name="password_nueva"
                           x-model="nueva"
                           autocomplete="new-password"
                           class="pass-input {{ $errors->has('password_nueva') ? 'is-error' : '' }}"
                           placeholder="Mínimo 8 caracteres"
                           required>
                    <button type="button" class="pass-toggle"
                            @click="showNueva = !showNueva">
                        <svg x-show="!showNueva" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showNueva" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7
                                     a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243
                                     M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29
                                     M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7
                                     a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>

                {{-- Indicadores de requisitos --}}
                <ul class="req-list">
                    <li class="req-item" :class="{ ok: minLen }">
                        <span class="dot"></span>8 caracteres mínimo
                    </li>
                    <li class="req-item" :class="{ ok: hasNum }">
                        <span class="dot"></span>Al menos 1 número
                    </li>
                    <li class="req-item" :class="{ ok: hasEsp }">
                        <span class="dot"></span>Al menos 1 carácter especial
                    </li>
                </ul>

                @error('password_nueva')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Repetir contraseña --}}
            <div class="pass-group">
                <label class="pass-label" for="password_nueva_confirmation">
                    Repite la contraseña nueva<span>*</span>
                </label>
                <div class="pass-wrapper">
                    <input id="password_nueva_confirmation"
                           :type="showRepite ? 'text' : 'password'"
                           name="password_nueva_confirmation"
                           x-model="repite"
                           autocomplete="new-password"
                           :class="repite.length > 0 && !coincide ? 'pass-input is-error' : 'pass-input'"
                           placeholder="Repite la nueva contraseña"
                           required>
                    <button type="button" class="pass-toggle"
                            @click="showRepite = !showRepite">
                        <svg x-show="!showRepite" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showRepite" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7
                                     a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243
                                     M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29
                                     M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7
                                     a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <p x-show="repite.length > 0 && !coincide"
                   class="field-error" x-transition>
                    Las contraseñas no coinciden.
                </p>
                @error('password_nueva_confirmation')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón Cambiar --}}
            <div class="flex justify-end mt-2">
                <button type="submit"
                        :disabled="!minLen || !hasNum || !hasEsp || !coincide || actual.length === 0"
                        class="btn-cambiar disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581
                                 m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Cambiar
                </button>
            </div>

        </form>
    </div>

    {{-- Toast de éxito --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition
         class="fixed bottom-6 right-6 z-50 bg-green-600 text-white text-sm font-semibold
                px-5 py-3 rounded-xl shadow-lg flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

</div>

@endsection
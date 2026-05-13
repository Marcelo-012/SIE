{{-- ================================================================
     PANEL GRUPOS — Alpine.js component
================================================================ --}}
<div x-show="paginaActiva === 'grupos'"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-data="gruposPanel()"
     x-init="init()"
     class="flex-1 flex flex-col min-h-0">

    {{-- ── SUBPANEL: Calificar ──────────────────────────────────── --}}
    <div x-show="subPanel === 'calificar'" x-cloak class="flex-1 overflow-y-auto p-6 lg:p-8">
        @include('docentes.partials.calificar-panel')
    </div>

    {{-- ── SUBPANEL: Programa ───────────────────────────────────── --}}
    <div x-show="subPanel === 'programa'" x-cloak class="flex-1 overflow-y-auto p-6 lg:p-8">
        @include('docentes.partials.programa-panel')
    </div>

    {{-- ── PANEL PRINCIPAL ─────────────────────────────────────── --}}
    <div x-show="subPanel === null" class="flex-1 overflow-y-auto p-6 lg:p-8">

        {{-- Título --}}
        <div class="mb-5">
            <h1 class="text-xl font-extrabold text-gray-800">Grupos</h1>
            <p class="text-sm text-gray-400 mt-0.5">Gestiona tus grupos, horarios y calificaciones</p>
        </div>

        {{-- Selector de ciclo escolar --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-5">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                Ciclo escolar
            </label>
            <div class="flex gap-3 items-center">
                <select x-model="cicloSeleccionado"
                        class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white">
                    <option value="">— Selecciona un periodo —</option>
                    <template x-for="c in ciclos" :key="c.id_ciclo_escolar">
                        <option :value="c.id_ciclo_escolar" x-text="c.nombre_ciclo_escolar"></option>
                    </template>
                </select>
                <button @click="cargarDatos()"
                        :disabled="!cicloSeleccionado || cargando"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                               bg-purple-700 text-white hover:bg-purple-800 disabled:opacity-50
                               transition-colors">
                    <svg class="w-4 h-4" :class="cargando ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Cambiar</span>
                </button>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 mb-5 bg-slate-100 rounded-xl p-1 w-fit">
            <button @click="tabActivo = 'materias'"
                    :class="tabActivo === 'materias'
                        ? 'bg-purple-700 text-white shadow-sm'
                        : 'text-gray-500 hover:text-gray-700'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Materias
            </button>
            <button @click="tabActivo = 'horario'"
                    :class="tabActivo === 'horario'
                        ? 'bg-purple-700 text-white shadow-sm'
                        : 'text-gray-500 hover:text-gray-700'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Horario
            </button>
            <button @click="tabActivo = 'reportes'"
                    :class="tabActivo === 'reportes'
                        ? 'bg-purple-700 text-white shadow-sm'
                        : 'text-gray-500 hover:text-gray-700'"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Reportes
            </button>
        </div>

        {{-- Estado: cargando --}}
        <div x-show="cargando" class="flex items-center justify-center py-20">
            <div class="flex flex-col items-center gap-3">
                <svg class="w-8 h-8 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                <p class="text-sm text-gray-400">Cargando datos...</p>
            </div>
        </div>

        {{-- Estado: sin grupos --}}
        <div x-show="!cargando && grupos.length === 0 && cicloSeleccionado" class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-16 text-center px-8">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">No tienes grupos asignados en este ciclo escolar.</p>
        </div>

        {{-- ── TAB: MATERIAS ───────────────────────────────────── --}}
        <div x-show="!cargando && tabActivo === 'materias' && grupos.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <template x-for="g in grupos" :key="g.id_grupo">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-3">

                        {{-- Icono + info --}}
                        <div class="flex gap-3 items-start">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-purple-700 leading-tight"
                                   x-text="(g.materia?.clave_materia ?? '') + ' ' + (g.materia?.nombre_materia ?? 'Sin materia')"></p>
                                <p class="text-xs text-gray-500 mt-0.5" x-text="'Plan: ' + (g.materia?.plan_estudios ?? '—')"></p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    <span x-text="'Grupo: ' + g.letra"></span>
                                    &nbsp;·&nbsp;
                                    <span x-text="'Idioma: ' + (g.materia?.idioma ?? 'Español')"></span>
                                </p>
                            </div>
                        </div>

                        {{-- Badges --}}
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600"
                                  x-text="g.cupo + '/' + g.cupo_max + ' alumnos'"></span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-600"
                                  x-text="(g.materia?.unidades ?? '?') + ' unidades'"></span>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex gap-2 pt-1 border-t border-slate-50">
                            <button @click="abrirCalificar(g)"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                                           text-sm font-semibold text-emerald-700 border border-emerald-200
                                           hover:bg-emerald-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Calificar
                            </button>
                            <button @click="abrirPrograma(g)"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                                           text-sm font-semibold text-indigo-600 border border-indigo-200
                                           hover:bg-indigo-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Programa
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ── TAB: HORARIO ────────────────────────────────────── --}}
        <div x-show="!cargando && tabActivo === 'horario' && grupos.length > 0">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
                <table class="w-full min-w-[600px] border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <template x-for="dia in ['Lunes','Martes','Miércoles','Jueves','Viernes']" :key="dia">
                                <th class="px-4 py-3 text-center text-xs font-bold text-purple-700 uppercase tracking-wider w-1/5"
                                    x-text="dia"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <template x-for="dia in ['lunes','martes','miercoles','jueves','viernes']" :key="dia">
                                <td class="px-3 py-3 align-top border-r border-slate-50 last:border-0 w-1/5">
                                    <template x-for="bloque in horariosDelDia(dia)" :key="bloque.id_horario">
                                        <div class="mb-2 bg-purple-50 border-l-4 border-purple-500 rounded-r-xl px-3 py-2">
                                            <p class="text-xs font-bold text-purple-700 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0"/>
                                                </svg>
                                                <span x-text="bloque.hora_inicio + ' - ' + bloque.hora_final"></span>
                                            </p>
                                            <p class="text-xs text-gray-700 font-semibold mt-0.5 leading-tight"
                                               x-text="bloque.materia_nombre"></p>
                                            <p class="text-xs text-gray-400 mt-0.5"
                                               x-text="'Aula: ' + (bloque.salon ?? '—') + ' / Grupo: ' + bloque.grupo_letra"></p>
                                        </div>
                                    </template>
                                    <div x-show="horariosDelDia(dia).length === 0"
                                         class="h-12 flex items-center justify-center">
                                        <span class="text-xs text-slate-300">—</span>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── TAB: REPORTES ───────────────────────────────────── --}}
        <div x-show="!cargando && tabActivo === 'reportes' && grupos.length > 0">

            <template x-if="grupos.length === 1">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <template x-for="reporte in reportesTipos" :key="reporte.key">
                        <a :href="'/docente/grupos/' + grupos[0].id_grupo + '/reporte/' + reporte.key"
                           target="_blank"
                           class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4
                                  hover:border-purple-200 hover:shadow-md transition-all group cursor-pointer">
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-700 group-hover:text-purple-700 transition-colors"
                                   x-text="reporte.label"></p>
                                <p class="text-xs text-gray-400 mt-0.5" x-text="reporte.desc"></p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-400 flex-shrink-0 transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </template>
                </div>
            </template>

            <template x-if="grupos.length > 1">
                <div class="space-y-4">
                    <template x-for="g in grupos" :key="g.id_grupo">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                            <p class="text-sm font-bold text-gray-700 mb-3"
                               x-text="(g.materia?.nombre_materia ?? '—') + ' — Grupo ' + g.letra"></p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <template x-for="reporte in reportesTipos" :key="reporte.key">
                                    <a :href="'/docente/grupos/' + g.id_grupo + '/reporte/' + reporte.key"
                                       target="_blank"
                                       class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-100
                                              hover:border-purple-200 hover:bg-purple-50 transition-all group">
                                        <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-sm text-gray-600 group-hover:text-purple-700 transition-colors"
                                              x-text="reporte.label"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

    </div>{{-- /panel principal --}}
</div>

<script>
function gruposPanel() {
    return {
        ciclos: [],
        cicloSeleccionado: null,
        grupos: [],
        cargando: false,
        tabActivo: 'materias',
        subPanel: null,

        // ── Estado calificar ────────────────────────────────────
        grupoCalificar: null,
        inscripciones: [],
        cargandoCalificar: false,
        tabCalificar: 'unidades',

        // ── Estado programa ─────────────────────────────────────
        grupoPrograma: null,
        programaCargando: false,
        tabPrograma: 'estudiantes',
        programaEstudiantes: [],
        programaTemario: [],
        programaTareas: {},
        programaObjetivo: null,
        programaBibliografia: '',
        programaGuardandoBiblio: false,
        modalTareaOpen: false,
        nuevaTareaUnidad: 1,
        nuevaTareaTitulo: '',
        nuevaTareaDesc: '',
        nuevaTareaFecha: '',

        programaTabs: [
            { key: 'estudiantes', label: 'Estudiantes', icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>' },
            { key: 'temario',     label: 'Temario',     icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10"/></svg>' },
            { key: 'tareas',      label: 'Tareas',      icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>' },
            { key: 'objetivo',    label: 'Objetivo',    icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/><line x1="12" y1="2" x2="12" y2="8" stroke="currentColor" stroke-width="2"/></svg>' },
            { key: 'bibliografia', label: 'Bibliografía', icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>' },
            { key: 'documentos',  label: 'Documentos',  icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>' },
        ],

        reportesTipos: [
            { key: 'inicio',      label: 'Reporte de inicio de curso', desc: 'Lista de alumnos inscritos' },
            { key: 'intermedio',  label: 'Reporte intermedio',         desc: 'Calificaciones parciales' },
            { key: 'fin',         label: 'Reporte de fin de curso',    desc: 'Calificaciones finales' },
        ],

        async init() {
            await this.cargarCiclos();
        },

        async cargarCiclos() {
            try {
                const res = await fetch('/docente/grupos/ciclos', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.ciclos = data.ciclos;
                if (data.cicloActual) {
                    this.cicloSeleccionado = data.cicloActual;
                    await this.cargarDatos();
                }
            } catch (e) {
                console.error('Error cargando ciclos', e);
            }
        },

        async cargarDatos() {
            if (!this.cicloSeleccionado) return;
            this.cargando = true;
            try {
                const res = await fetch(`/docente/grupos/datos?ciclo=${this.cicloSeleccionado}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.grupos = data.grupos;
            } catch (e) {
                console.error('Error cargando grupos', e);
            } finally {
                this.cargando = false;
            }
        },

        horariosDelDia(dia) {
            const bloques = [];
            for (const g of this.grupos) {
                for (const h of (g.horarios ?? [])) {
                    const diaNorm = h.dia_semana.normalize('NFD').replace(/\p{Diacritic}/gu, '').toLowerCase();
                    if (diaNorm === dia) {
                        bloques.push({
                            ...h,
                            materia_nombre: g.materia?.nombre_materia ?? '—',
                            grupo_letra: g.letra,
                        });
                    }
                }
            }
            return bloques.sort((a, b) => a.hora_inicio.localeCompare(b.hora_inicio));
        },

        async abrirCalificar(grupo) {
            this.grupoCalificar = grupo;
            this.subPanel = 'calificar';
            this.tabCalificar = 'unidades';
            this.cargandoCalificar = true;
            try {
                const res = await fetch(`/docente/grupos/${grupo.id_grupo}/calificar`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.grupoCalificar = { ...grupo, ...data.grupo };
                this.inscripciones = data.inscripciones;
            } catch (e) {
                console.error('Error cargando calificaciones', e);
            } finally {
                this.cargandoCalificar = false;
            }
        },

        volverDeCalificar() {
            this.subPanel = null;
            this.grupoCalificar = null;
            this.inscripciones = [];
        },

        intentoLabel(intento) {
            const labels = { 1: '1ª oportunidad', 2: '2ª oportunidad', 3: '3ª oportunidad' };
            return labels[intento] ?? `${intento}ª oportunidad`;
        },

        async guardarCal(idInscripcion, tipo, valor) {
            if (valor === '' || valor === null || valor === undefined) {
                valor = null;
            } else {
                const num = parseInt(valor);
                if (isNaN(num) || num < 0 || num > 100) return;
                valor = num;
            }
            await fetch('/docente/grupos/calificacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ id_inscripcion: idInscripcion, tipo, valor }),
            });
        },

        async guardarDesercion(idInscripcion, valor) {
            await fetch('/docente/grupos/desercion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ id_inscripcion: idInscripcion, desercion: valor }),
            });
        },

        promedio(ins) {
            const vals = Object.values(ins.unidades ?? {}).filter(v => v !== null && v !== undefined);
            if (!vals.length) return 'N/A';
            return (vals.reduce((a, b) => a + b, 0) / vals.length).toFixed(1);
        },

        // ── Métodos Programa ────────────────────────────────────
        async abrirPrograma(grupo) {
            this.grupoPrograma = grupo;
            this.subPanel = 'programa';
            this.tabPrograma = 'estudiantes';
            this.programaCargando = true;
            try {
                const res = await fetch(`/docente/grupos/${grupo.id_grupo}/programa/datos`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.grupoPrograma = { ...grupo, ...data.grupo };
                this.programaEstudiantes = data.estudiantes;
                this.programaTemario = (data.temario ?? []).map(u => ({ ...u, _open: false }));
                this.programaTareas = data.tareas ?? {};
                this.programaObjetivo = data.objetivo;
                this.programaBibliografia = data.bibliografia ?? '';
            } catch (e) {
                console.error('Error cargando programa', e);
            } finally {
                this.programaCargando = false;
            }
        },

        volverDePrograma() {
            this.subPanel = null;
            this.grupoPrograma = null;
            this.programaEstudiantes = [];
            this.programaTemario = [];
            this.programaTareas = {};
            this.programaObjetivo = null;
            this.programaBibliografia = '';
        },

        temarioTitulo(numero) {
            const u = this.programaTemario.find(t => t.numero === numero);
            return u ? u.titulo : '';
        },

        imprimirEstudiantes() {
            const printArea = document.getElementById('print-estudiantes');
            if (!printArea) return window.print();
            printArea.classList.remove('hidden');
            window.print();
            printArea.classList.add('hidden');
        },

        async guardarBibliografia() {
            if (!this.grupoPrograma) return;
            this.programaGuardandoBiblio = true;
            try {
                await fetch(`/docente/grupos/${this.grupoPrograma.id_grupo}/programa/bibliografia`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ texto: this.programaBibliografia }),
                });
            } catch (e) {
                console.error('Error guardando bibliografía', e);
            } finally {
                this.programaGuardandoBiblio = false;
            }
        },

        abrirModalTarea() {
            this.nuevaTareaUnidad = 1;
            this.nuevaTareaTitulo = '';
            this.nuevaTareaDesc = '';
            this.nuevaTareaFecha = '';
            this.modalTareaOpen = true;
        },

        async guardarNuevaTarea() {
            if (!this.nuevaTareaTitulo.trim() || !this.grupoPrograma) return;
            try {
                const res = await fetch(`/docente/grupos/${this.grupoPrograma.id_grupo}/programa/tareas`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        numero_unidad: this.nuevaTareaUnidad,
                        titulo:        this.nuevaTareaTitulo,
                        descripcion:   this.nuevaTareaDesc || null,
                        fecha_entrega: this.nuevaTareaFecha || null,
                    }),
                });
                const data = await res.json();
                if (data.ok) {
                    const u = this.nuevaTareaUnidad;
                    if (!this.programaTareas[u]) this.programaTareas[u] = [];
                    this.programaTareas[u] = [...this.programaTareas[u], data.tarea];
                    this.modalTareaOpen = false;
                }
            } catch (e) {
                console.error('Error creando tarea', e);
            }
        },

        async eliminarTareaPrograma(idTarea, unidad) {
            if (!this.grupoPrograma) return;
            if (!confirm('¿Eliminar esta tarea?')) return;
            try {
                await fetch(`/docente/grupos/${this.grupoPrograma.id_grupo}/programa/tareas/${idTarea}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                if (this.programaTareas[unidad]) {
                    this.programaTareas[unidad] = this.programaTareas[unidad].filter(t => t.id_tarea !== idTarea);
                }
            } catch (e) {
                console.error('Error eliminando tarea', e);
            }
        },
    };
}
</script>

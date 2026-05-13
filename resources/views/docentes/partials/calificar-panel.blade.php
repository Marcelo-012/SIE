{{-- ================================================================
     SUBPANEL CALIFICAR — usa el estado de gruposPanel()
================================================================ --}}

{{-- Breadcrumb --}}
<div class="mb-5">
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
        <button @click="volverDeCalificar()" class="hover:text-purple-600 transition-colors">Grupos</button>
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
        </svg>
        <span class="font-medium text-gray-600" x-text="grupoCalificar?.materia?.nombre_materia ?? 'Calificar'"></span>
    </div>

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-gray-800"
                x-text="(grupoCalificar?.materia?.clave_materia ?? '') + ' ' + (grupoCalificar?.materia?.nombre_materia ?? '')"></h1>
            <p class="text-sm text-gray-400 mt-0.5">
                <span x-text="'Plan: ' + (grupoCalificar?.materia?.plan_estudios ?? '—')"></span>
                <template x-if="grupoCalificar?.materia?.departamento">
                    <span> &nbsp;·&nbsp; <span x-text="grupoCalificar.materia.departamento"></span></span>
                </template>
            </p>
        </div>
        <button @click="volverDeCalificar()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </button>
    </div>
</div>

{{-- Tabs Unidades / Finales --}}
<div class="flex gap-1 mb-5 bg-slate-100 rounded-xl p-1 w-fit">
    <button @click="tabCalificar = 'unidades'"
            :class="tabCalificar === 'unidades' ? 'bg-purple-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
        Unidades
    </button>
    <button @click="tabCalificar = 'finales'"
            :class="tabCalificar === 'finales' ? 'bg-purple-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
        Finales
    </button>
</div>

{{-- Cargando --}}
<div x-show="cargandoCalificar" class="flex items-center justify-center py-20">
    <div class="flex flex-col items-center gap-3">
        <svg class="w-8 h-8 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        <p class="text-sm text-gray-400">Cargando alumnos...</p>
    </div>
</div>

{{-- Sin alumnos --}}
<div x-show="!cargandoCalificar && inscripciones.length === 0"
     class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-16 text-center px-8">
    <p class="text-gray-400 text-sm font-medium">No hay alumnos inscritos en este grupo.</p>
</div>

{{-- ── TAB: UNIDADES ─────────────────────────────────────────── --}}
<div x-show="!cargandoCalificar && tabCalificar === 'unidades' && inscripciones.length > 0">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
        <table class="w-full text-sm border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Matrícula</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre del estudiante</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Curso</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Eval. Diagnóstica</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Reporte Intermedio</th>
                    <template x-for="u in (grupoCalificar?.unidades ?? 3)" :key="u">
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider"
                            x-text="'Unidad ' + u"></th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template x-for="ins in inscripciones" :key="ins.id_inscripcion">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs text-gray-600" x-text="ins.matricula"></td>
                        <td class="px-4 py-3 text-gray-800 font-medium" x-text="ins.nombre_alumno"></td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700"
                                  x-text="intentoLabel(ins.intento)"></span>
                        </td>
                        {{-- Evaluación Diagnóstica --}}
                        <td class="px-4 py-3 text-center">
                            <input type="number" min="0" max="100"
                                   :value="ins.cal_diagnostica ?? ''"
                                   @change="
                                       ins.cal_diagnostica = $event.target.value ? parseInt($event.target.value) : null;
                                       guardarCal(ins.id_inscripcion, 'diagnostica', $event.target.value)
                                   "
                                   class="w-16 text-center border border-slate-200 rounded-lg px-2 py-1 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-purple-300">
                        </td>
                        {{-- Reporte Intermedio --}}
                        <td class="px-4 py-3 text-center">
                            <input type="number" min="0" max="100"
                                   :value="ins.cal_reporte_intermedio ?? ''"
                                   @change="
                                       ins.cal_reporte_intermedio = $event.target.value ? parseInt($event.target.value) : null;
                                       guardarCal(ins.id_inscripcion, 'reporte', $event.target.value)
                                   "
                                   class="w-16 text-center border border-slate-200 rounded-lg px-2 py-1 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-purple-300">
                        </td>
                        {{-- Unidades dinámicas --}}
                        <template x-for="u in (grupoCalificar?.unidades ?? 3)" :key="u">
                            <td class="px-4 py-3 text-center">
                                <input type="number" min="0" max="100"
                                       :value="ins.unidades[u] ?? ''"
                                       @change="
                                           ins.unidades[u] = $event.target.value ? parseInt($event.target.value) : null;
                                           guardarCal(ins.id_inscripcion, u, $event.target.value)
                                       "
                                       class="w-16 text-center border border-slate-200 rounded-lg px-2 py-1 text-sm
                                              focus:outline-none focus:ring-2 focus:ring-purple-300">
                            </td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

{{-- ── TAB: FINALES ──────────────────────────────────────────── --}}
<div x-show="!cargandoCalificar && tabCalificar === 'finales' && inscripciones.length > 0">
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-4 text-sm text-blue-700 flex items-start gap-2">
        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Las calificaciones finales se guardan automáticamente al modificar el campo. Marca la casilla de Deserción para los alumnos que no completaron el curso.</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
        <table class="w-full text-sm border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Matrícula</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre del estudiante</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Curso</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Promedio</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Calificación final</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Deserción</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="ins in inscripciones" :key="ins.id_inscripcion">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors"
                        :class="ins.desercion ? 'opacity-60' : ''">
                        <td class="px-4 py-3 font-mono text-xs text-gray-600" x-text="ins.matricula"></td>
                        <td class="px-4 py-3 text-gray-800 font-medium" x-text="ins.nombre_alumno"></td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700"
                                  x-text="intentoLabel(ins.intento)"></span>
                        </td>
                        {{-- Promedio calculado --}}
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-medium text-gray-600"
                                  x-text="promedio(ins)"></span>
                        </td>
                        {{-- Calificación final --}}
                        <td class="px-4 py-3 text-center">
                            <input type="number" min="0" max="100"
                                   :value="ins.calificacion_final ?? ''"
                                   :disabled="ins.desercion"
                                   @change="
                                       ins.calificacion_final = $event.target.value ? parseInt($event.target.value) : null;
                                       guardarCal(ins.id_inscripcion, 'final', $event.target.value)
                                   "
                                   class="w-16 text-center border border-slate-200 rounded-lg px-2 py-1 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-purple-300
                                          disabled:opacity-40 disabled:cursor-not-allowed">
                        </td>
                        {{-- Deserción --}}
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                   :checked="ins.desercion"
                                   @change="
                                       ins.desercion = $event.target.checked;
                                       guardarDesercion(ins.id_inscripcion, $event.target.checked)
                                   "
                                   class="w-4 h-4 rounded text-purple-600 border-slate-300
                                          focus:ring-purple-500 cursor-pointer">
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>


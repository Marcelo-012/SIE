{{-- ================================================================
     SUBPANEL PROGRAMA — usa el estado de gruposPanel()
================================================================ --}}

{{-- Encabezado --}}
<div class="mb-5">
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
        <button @click="volverDePrograma()" class="hover:text-purple-600 transition-colors">Grupos</button>
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
        </svg>
        <span class="font-medium text-gray-600"
              x-text="(grupoPrograma?.materia?.clave_materia ?? '') + ' ' + (grupoPrograma?.materia?.nombre_materia ?? 'Programa')"></span>
    </div>

    <div class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-4">
            {{-- Icono materia --}}
            <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-purple-700 leading-tight"
                    x-text="(grupoPrograma?.materia?.clave_materia ?? '') + ' ' + (grupoPrograma?.materia?.nombre_materia ?? '') + ' / ' + (grupoPrograma?.letra ?? '')"></h1>
                <p class="text-xs text-gray-500 mt-0.5"
                   x-text="'Plan: ' + (grupoPrograma?.materia?.plan_estudios ?? '—')"></p>
                <p class="text-xs text-gray-400"
                   x-text="'Departamento: ' + (grupoPrograma?.materia?.departamento ?? '—')"></p>
            </div>
        </div>
    </div>
</div>

{{-- Tabs --}}
<div class="flex flex-wrap gap-1 mb-5 bg-slate-100 rounded-xl p-1">
    <template x-for="tab in programaTabs" :key="tab.key">
        <button @click="tabPrograma = tab.key"
                :class="tabPrograma === tab.key
                    ? 'bg-purple-700 text-white shadow-sm'
                    : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
            <span x-html="tab.icon"></span>
            <span x-text="tab.label"></span>
        </button>
    </template>
</div>

{{-- Cargando --}}
<div x-show="programaCargando" class="flex items-center justify-center py-20">
    <div class="flex flex-col items-center gap-3">
        <svg class="w-8 h-8 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        <p class="text-sm text-gray-400">Cargando programa...</p>
    </div>
</div>

{{-- ── TAB: ESTUDIANTES ─────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'estudiantes'">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Matrícula</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre del estudiante</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(est, i) in programaEstudiantes" :key="est.matricula">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors"
                        :class="i % 2 === 0 ? '' : 'bg-slate-50/30'">
                        <td class="px-4 py-3 font-mono text-xs text-gray-500" x-text="est.matricula"></td>
                        <td class="px-4 py-3 text-gray-800 font-medium" x-text="est.nombre"></td>
                    </tr>
                </template>
                <tr x-show="programaEstudiantes.length === 0">
                    <td colspan="2" class="px-4 py-10 text-center text-sm text-gray-400">No hay alumnos inscritos.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
        <div class="flex gap-2">
            <button @click="imprimirEstudiantes()"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           bg-amber-400 hover:bg-amber-500 text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimir
            </button>
            <a :href="'/docente/grupos/' + grupoPrograma?.id_grupo + '/programa/estudiantes/descargar'"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                      bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Descargar
            </a>
        </div>
    </div>
</div>

{{-- ── TAB: TEMARIO ─────────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'temario'">

    <div class="space-y-3 mb-4">
        <template x-if="programaTemario.length > 0">
            <div class="space-y-3">
                <template x-for="unidad in programaTemario" :key="unidad.id_unidad">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 cursor-pointer
                                hover:border-purple-200 transition-all group"
                         @click="unidad._open = !unidad._open">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800"
                                   x-text="'Unidad ' + unidad.numero + ' - ' + unidad.titulo"></p>
                                <p class="text-xs text-amber-600 mt-0.5 truncate" x-text="unidad.descripcion ?? ''"></p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-400 flex-shrink-0 transition-all"
                                 :class="unidad._open ? 'rotate-90' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div x-show="unidad._open" x-collapse class="mt-3 pt-3 border-t border-slate-100">
                            <p class="text-sm text-gray-600 leading-relaxed" x-text="unidad.descripcion ?? 'Sin descripción.'"></p>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="programaTemario.length === 0">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-12 text-center px-8">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400 font-medium">El temario de esta materia aún no ha sido configurado.</p>
            </div>
        </template>
    </div>

    <div class="flex justify-between items-center">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
        <div class="flex gap-2">
            <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           bg-amber-400 hover:bg-amber-500 text-white transition-colors opacity-60 cursor-not-allowed" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
                Configuración
            </button>
            <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           bg-purple-700 hover:bg-purple-800 text-white transition-colors opacity-60 cursor-not-allowed" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Planeación
            </button>
        </div>
    </div>
</div>

{{-- ── TAB: TAREAS ──────────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'tareas'">

    <div class="space-y-4 mb-4">
        <template x-for="u in (grupoPrograma?.unidades ?? 3)" :key="u">
            <div>
                <h3 class="text-sm font-bold text-gray-700 mb-2"
                    x-text="'Unidad ' + u + (temarioTitulo(u) ? ' - ' + temarioTitulo(u) : '')"></h3>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                    {{-- Lista de tareas de la unidad --}}
                    <template x-if="(programaTareas[u] ?? []).length > 0">
                        <div class="divide-y divide-slate-50">
                            <template x-for="tarea in (programaTareas[u] ?? [])" :key="tarea.id_tarea">
                                <div class="flex items-start justify-between gap-3 px-4 py-3 group hover:bg-slate-50/50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 mt-0.5 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800" x-text="tarea.titulo"></p>
                                            <p class="text-xs text-gray-400 mt-0.5" x-show="tarea.descripcion" x-text="tarea.descripcion"></p>
                                            <p class="text-xs text-purple-500 mt-0.5" x-show="tarea.fecha_entrega"
                                               x-text="'Entrega: ' + (tarea.fecha_entrega ?? '')"></p>
                                        </div>
                                    </div>
                                    <button @click="eliminarTareaPrograma(tarea.id_tarea, u)"
                                            class="opacity-0 group-hover:opacity-100 flex-shrink-0 w-7 h-7 rounded-lg
                                                   flex items-center justify-center text-red-400 hover:bg-red-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- Sin tareas --}}
                    <template x-if="(programaTareas[u] ?? []).length === 0">
                        <div class="px-4 py-5 text-center">
                            <p class="text-sm text-gray-400">No hay tareas programadas para esta unidad.</p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <div class="flex justify-between items-center">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
        <button @click="abrirModalTarea()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                       bg-purple-700 hover:bg-purple-800 text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva tarea
        </button>
    </div>

    {{-- Modal: Nueva tarea --}}
    <div x-show="modalTareaOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" @click="modalTareaOpen = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10">
            <h3 class="text-base font-bold text-gray-800 mb-4">Nueva tarea</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Unidad</label>
                    <select x-model="nuevaTareaUnidad"
                            class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                   focus:outline-none focus:ring-2 focus:ring-purple-300">
                        <template x-for="u in (grupoPrograma?.unidades ?? 3)" :key="u">
                            <option :value="u" x-text="'Unidad ' + u + (temarioTitulo(u) ? ' - ' + temarioTitulo(u) : '')"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Título *</label>
                    <input type="text" x-model="nuevaTareaTitulo" placeholder="Nombre de la tarea"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Descripción</label>
                    <textarea x-model="nuevaTareaDesc" rows="2" placeholder="Descripción opcional..."
                              class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                     focus:outline-none focus:ring-2 focus:ring-purple-300 resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Fecha de entrega</label>
                    <input type="date" x-model="nuevaTareaFecha"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
            </div>

            <div class="flex gap-2 mt-5">
                <button @click="modalTareaOpen = false"
                        class="flex-1 px-4 py-2 rounded-xl text-sm font-semibold text-gray-500
                               border border-slate-200 hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button @click="guardarNuevaTarea()"
                        :disabled="!nuevaTareaTitulo.trim()"
                        class="flex-1 px-4 py-2 rounded-xl text-sm font-semibold bg-purple-700 text-white
                               hover:bg-purple-800 disabled:opacity-50 transition-colors">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── TAB: OBJETIVO ────────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'objetivo'">

    <div class="space-y-4 mb-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-100 px-5 py-3">
                <p class="text-sm font-semibold text-gray-700">Objetivo de la materia</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-sm text-gray-700 leading-relaxed"
                   x-text="programaObjetivo?.objetivo || 'El objetivo de la materia aún no ha sido capturado.'"></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-100 px-5 py-3">
                <p class="text-sm font-semibold text-gray-700">Caracterización</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-sm text-gray-600 leading-relaxed"
                   x-text="programaObjetivo?.caracterizacion || 'La caracterización de la materia aún no ha sido capturada.'"></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-100 px-5 py-3">
                <p class="text-sm font-semibold text-gray-700">Intención didáctica</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-sm text-gray-600 leading-relaxed"
                   x-text="programaObjetivo?.intencion_didactica || 'La intención didáctica de la materia aún no ha sido capturada.'"></p>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
    </div>
</div>

{{-- ── TAB: BIBLIOGRAFÍA ────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'bibliografia'">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4">
        <div class="bg-slate-50 border-b border-slate-100 px-5 py-3">
            <p class="text-sm font-semibold text-gray-700">Bibliografía y referencias</p>
        </div>
        <div class="p-4">
            {{-- Mini toolbar (visual only) --}}
            <div class="flex flex-wrap gap-1 mb-2 p-2 border border-slate-200 rounded-t-lg bg-slate-50 text-xs text-gray-500">
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50">B</span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50 italic">I</span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50 underline">U</span>
                <span class="w-px bg-slate-200 mx-1"></span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50">≡</span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50">≡</span>
                <span class="w-px bg-slate-200 mx-1"></span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50">• Lista</span>
                <span class="px-2 py-1 rounded cursor-not-allowed opacity-50">1. Lista</span>
            </div>
            <textarea x-model="programaBibliografia"
                      rows="8"
                      placeholder="Escribe aquí..."
                      class="w-full border border-slate-200 border-t-0 rounded-b-lg px-4 py-3 text-sm text-gray-700
                             focus:outline-none focus:ring-2 focus:ring-purple-300 resize-none leading-relaxed"></textarea>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
        <button @click="guardarBibliografia()"
                :disabled="programaGuardandoBiblio"
                class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-semibold
                       bg-emerald-600 hover:bg-emerald-700 text-white disabled:opacity-60 transition-colors">
            <svg class="w-4 h-4" :class="programaGuardandoBiblio ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      x-show="!programaGuardandoBiblio"
                      d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                        x-show="programaGuardandoBiblio"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"
                      x-show="programaGuardandoBiblio"/>
            </svg>
            <span x-text="programaGuardandoBiblio ? 'Guardando...' : 'Guardar'"></span>
        </button>
    </div>
</div>

{{-- ── TAB: DOCUMENTOS ─────────────────────────────────────── --}}
<div x-show="!programaCargando && tabPrograma === 'documentos'">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <a :href="'/docente/grupos/' + grupoPrograma?.id_grupo + '/reporte/inicio'"
           target="_blank"
           class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4
                  hover:border-purple-200 hover:shadow-md transition-all group cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10">
                    <rect x="4" y="8" width="44" height="48" rx="4" fill="#FFC107" opacity="0.15"/>
                    <path d="M8 12 Q8 8 12 8 L44 8 Q48 8 48 12 L48 52 Q48 56 44 56 L8 56 Z" fill="#FFD54F"/>
                    <path d="M14 20 L38 20 M14 28 L38 28 M14 36 L30 36" stroke="#E65100" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="10" y="10" width="8" height="6" rx="1" fill="#F44336" opacity="0.7"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-purple-700 transition-colors">Gestión del curso</p>
                <p class="text-xs text-gray-400 mt-0.5">Lista de alumnos inscritos</p>
            </div>
            <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-400 flex-shrink-0 transition-colors"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <a :href="'/docente/grupos/' + grupoPrograma?.id_grupo + '/reporte/intermedio'"
           target="_blank"
           class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4
                  hover:border-purple-200 hover:shadow-md transition-all group cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10">
                    <rect x="4" y="8" width="44" height="48" rx="4" fill="#FFC107" opacity="0.15"/>
                    <path d="M8 12 Q8 8 12 8 L44 8 Q48 8 48 12 L48 52 Q48 56 44 56 L8 56 Z" fill="#FFD54F"/>
                    <path d="M14 20 L38 20 M14 28 L38 28 M14 36 L30 36" stroke="#E65100" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="10" y="10" width="8" height="6" rx="1" fill="#F44336" opacity="0.7"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-purple-700 transition-colors">Reporte de seguimiento</p>
                <p class="text-xs text-gray-400 mt-0.5">Calificaciones intermedias y finales</p>
            </div>
            <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-400 flex-shrink-0 transition-colors"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="flex justify-end">
        <button @click="volverDePrograma()"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-500
                       border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Atrás
        </button>
    </div>
</div>

{{-- Área de impresión oculta para Estudiantes --}}
<div id="print-estudiantes" class="hidden print:block">
    <div style="font-family: sans-serif; padding: 24px;">
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:bold; color:#4f46e5; margin:0"
                    x-text="(grupoPrograma?.materia?.clave_materia ?? '') + ' ' + (grupoPrograma?.materia?.nombre_materia ?? '') + ' / ' + (grupoPrograma?.letra ?? '')"></h2>
                <p style="font-size:12px; color:#6b7280; margin:2px 0 0"
                   x-text="'Plan: ' + (grupoPrograma?.materia?.plan_estudios ?? '—')"></p>
            </div>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 12px; text-align:left; border-bottom:1px solid #e2e8f0; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.05em">Matrícula</th>
                    <th style="padding:8px 12px; text-align:left; border-bottom:1px solid #e2e8f0; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.05em">Nombre del estudiante</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(est, i) in programaEstudiantes" :key="est.matricula">
                    <tr :style="i % 2 === 0 ? '' : 'background:#f8fafc'">
                        <td style="padding:7px 12px; border-bottom:1px solid #f1f5f9; font-family:monospace; color:#64748b" x-text="est.matricula"></td>
                        <td style="padding:7px 12px; border-bottom:1px solid #f1f5f9; font-weight:500" x-text="est.nombre"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

{{-- ================================================================
     PANEL TUTORÍAS — Alpine.js component
================================================================ --}}
<div x-show="paginaActiva === 'tutorias'"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-data="tutoriasPanel()"
     x-init="init()"
     class="p-6 lg:p-8">

    {{-- Título --}}
    <div class="mb-5">
        <h1 class="text-xl font-extrabold text-gray-800">Tutorías</h1>
        <p class="text-sm text-gray-400 mt-0.5">Seguimiento a alumnos tutorados</p>
    </div>

    {{-- Sección de filtros --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-5">
        <h2 class="text-sm font-bold text-gray-700 mb-4">Tutorados</h2>

        {{-- Fila 1: Matrícula + Periodo --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Matrícula</label>
                <input type="text"
                       x-model="filtros.matricula"
                       placeholder="Filtrar por matrícula..."
                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Periodo de asignación</label>
                <select x-model="filtros.periodo"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white">
                    <option value="">Todos</option>
                    <template x-for="c in ciclos" :key="c.id_ciclo_escolar">
                        <option :value="c.id_ciclo_escolar" x-text="c.nombre_ciclo_escolar"></option>
                    </template>
                </select>
            </div>
        </div>

        {{-- Fila 2: Nombre(s) + Apellido paterno + Apellido materno --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nombre(s)</label>
                <input type="text"
                       x-model="filtros.nombre"
                       placeholder="Filtrar por nombre..."
                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Apellido paterno</label>
                <input type="text"
                       x-model="filtros.apellidoPat"
                       placeholder="Filtrar por apellido paterno..."
                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Apellido materno</label>
                <input type="text"
                       x-model="filtros.apellidoMat"
                       placeholder="Filtrar por apellido materno..."
                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>
        </div>

        {{-- Fila 3: Estatus + Grado + Promedio --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Estatus</label>
                <select x-model="filtros.estatus"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white">
                    <option value="">Todos</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="egresado">Egresado</option>
                    <option value="baja">Baja</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Grado</label>
                <input type="text"
                       x-model="filtros.grado"
                       placeholder="Filtrar por grado..."
                       class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                              focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Promedio</label>
                <select x-model="filtros.promedio"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white">
                    <option value="">Todos</option>
                    <option value="alto">Alto (90-100)</option>
                    <option value="medio">Medio (70-89)</option>
                    <option value="bajo">Bajo (menos de 70)</option>
                </select>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-2">
            <button @click="filtrar()"
                    :disabled="cargando"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           bg-amber-400 hover:bg-amber-500 text-white disabled:opacity-60 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filtrar
            </button>
            <button @click="descargar()"
                    :disabled="cargando || tutorados.length === 0"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           bg-emerald-500 hover:bg-emerald-600 text-white disabled:opacity-60 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Descargar
            </button>
        </div>
    </div>

    {{-- Cargando --}}
    <div x-show="cargando" class="flex items-center justify-center py-16">
        <div class="flex flex-col items-center gap-3">
            <svg class="w-8 h-8 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            <p class="text-sm text-gray-400">Buscando tutorados...</p>
        </div>
    </div>

    {{-- Tabla de tutorados --}}
    <div x-show="!cargando && tutorados.length > 0"
         class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Matrícula</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre completo</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Grado</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Promedio</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estatus</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(t, i) in tutorados" :key="t.matricula">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors"
                        :class="i % 2 === 0 ? '' : 'bg-slate-50/30'">
                        <td class="px-4 py-3 font-mono text-xs text-gray-500" x-text="t.matricula"></td>
                        <td class="px-4 py-3 text-gray-800 font-medium" x-text="t.nombre"></td>
                        <td class="px-4 py-3 text-center text-gray-600 text-xs" x-text="t.grado ?? '—'"></td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-semibold"
                                  :class="(t.promedio ?? 0) >= 70 ? 'text-emerald-600' : 'text-red-500'"
                                  x-text="t.promedio !== null ? t.promedio : '—'"></span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                                  :class="{
                                      'bg-emerald-50 text-emerald-700': t.estatus === 'activo',
                                      'bg-slate-100 text-slate-500':    t.estatus === 'inactivo',
                                      'bg-blue-50 text-blue-700':       t.estatus === 'egresado',
                                      'bg-red-50 text-red-600':         t.estatus === 'baja',
                                  }"
                                  x-text="t.estatus ?? '—'"></span>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- Estado vacío (después de buscar) --}}
    <div x-show="!cargando && buscado && tutorados.length === 0"
         class="text-sm text-gray-500 py-2">
        No se encontraron estudiantes tutorados, es posible no se te haya asignado ninguno o tu búsqueda no contenga ningún resultado.
    </div>

    {{-- Estado inicial --}}
    <div x-show="!cargando && !buscado"
         class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-16 text-center px-8">
        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-400 font-medium">Aplica los filtros y presiona <strong>Filtrar</strong> para consultar tus tutorados.</p>
    </div>

</div>

<script>
function tutoriasPanel() {
    return {
        ciclos: [],
        cargando: false,
        buscado: false,
        tutorados: [],
        filtros: {
            matricula:  '',
            periodo:    '',
            nombre:     '',
            apellidoPat: '',
            apellidoMat: '',
            estatus:    '',
            grado:      '',
            promedio:   '',
        },

        async init() {
            try {
                const res = await fetch('/docente/grupos/ciclos', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.ciclos = data.ciclos ?? [];
            } catch (e) {
                console.error('Error cargando ciclos tutorías', e);
            }
        },

        filtrar() {
            this.cargando = true;
            this.tutorados = [];
            setTimeout(() => {
                this.cargando = false;
                this.buscado = true;
                this.tutorados = [];
            }, 400);
        },

        descargar() {
            if (!this.tutorados.length) return;
            const rows = [['Matrícula', 'Nombre', 'Grado', 'Promedio', 'Estatus']];
            this.tutorados.forEach(t => rows.push([t.matricula, t.nombre, t.grado ?? '', t.promedio ?? '', t.estatus ?? '']));
            const csv = rows.map(r => r.map(v => `"${String(v).replace(/"/g, '""')}"`).join(',')).join('\n');
            const a = document.createElement('a');
            a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
            a.download = 'tutorados.csv';
            a.click();
        },
    };
}
</script>

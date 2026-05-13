{{-- ================================================================
     PANEL PROPEDÉUTICO — Alpine.js component
================================================================ --}}
<div x-show="paginaActiva === 'propedeutico'"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-data="propedeuticoPanel()"
     x-init="init()"
     class="p-6 lg:p-8">

    {{-- Título --}}
    <div class="mb-5">
        <h1 class="text-xl font-extrabold text-gray-800">Propedéutico</h1>
        <p class="text-sm text-gray-400 mt-0.5">Seguimiento del módulo propedéutico</p>
    </div>

    {{-- Selector de periodo --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-5">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
            Periodo de propedéutico
        </label>
        <div class="flex gap-3 items-center">
            <select x-model="cicloSeleccionado"
                    class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white">
                <option value="">--Selecciona un periodo--</option>
                <template x-for="c in ciclos" :key="c.id_ciclo_escolar">
                    <option :value="c.id_ciclo_escolar" x-text="c.nombre_ciclo_escolar"></option>
                </template>
            </select>
            <button @click="buscar()"
                    :disabled="cargando"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                           bg-purple-700 text-white hover:bg-purple-800 disabled:opacity-50 transition-colors">
                <svg class="w-4 h-4" :class="cargando ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Cambiar</span>
            </button>
        </div>
    </div>

    {{-- Cargando --}}
    <div x-show="cargando" class="flex items-center justify-center py-20">
        <div class="flex flex-col items-center gap-3">
            <svg class="w-8 h-8 text-purple-400 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            <p class="text-sm text-gray-400">Consultando...</p>
        </div>
    </div>

    {{-- Estado vacío (no hay materias de propedéutico asignadas) --}}
    <div x-show="!cargando && buscado"
         class="text-sm text-gray-500 py-2">
        Al parecer no tienes materias asignadas en este ciclo, regresa más tarde o selecciona otro periodo.
    </div>

    {{-- Estado inicial (aún no se ha buscado) --}}
    <div x-show="!cargando && !buscado && !cicloSeleccionado"
         class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-16 text-center px-8">
        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-400 font-medium">Selecciona un periodo y presiona <strong>Cambiar</strong> para consultar.</p>
    </div>

</div>

<script>
function propedeuticoPanel() {
    return {
        ciclos: [],
        cicloSeleccionado: '',
        cargando: false,
        buscado: false,

        async init() {
            try {
                const res = await fetch('/docente/grupos/ciclos', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.ciclos = data.ciclos ?? [];
            } catch (e) {
                console.error('Error cargando ciclos propedéutico', e);
            }
        },

        buscar() {
            this.cargando = true;
            this.buscado = false;
            setTimeout(() => {
                this.cargando = false;
                this.buscado = true;
            }, 500);
        },
    };
}
</script>

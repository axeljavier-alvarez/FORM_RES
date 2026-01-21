<x-interno-layout :breadcrumb="[
    [
        'name' => 'Dashboard',
        'url' => route('interno.dashboard.index')
    ],
    [
        'name' => 'Consulta de solicitudes',
    ]
]">

    @livewire('solicitud-table')

   <!-- modal para ver acciones -->

    <div x-data="{ 
    open: true, 
    solicitud: {} 
    }" 

    @open-modal-detalle.window="
    open = true; 
    solicitud = $event.detail.solicitud
    "

     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-cabellad="modal-title" role="dialog" aria-modal="true">

    <div x-show="open"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity z-50"
    @click="open = true">
    </div>          

      <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>


        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
         @click="open = false">
    </div>

        
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                <div x-show="open"
                x-cloak
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">

                <!--encabezado -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white leading-tight">
                                Detalle de Solicitud
                            </h3>
                            <p class="text-blue-100 text-sm font-medium">No. <span x-text="solicitud.no_solicitud"></span></p>
                        </div>
                    </div>

                    <button @click="open = false" type="button" class="text-white/80 hover:text-white hover:bg-white/10 p-2 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                            <span class="text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                            <h4 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Información del Solicitante</h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nombre Completo</label>
                                    <p class="text-gray-900 font-semibold" x-text="solicitud.nombres + ' ' + (solicitud.apellidos || '')"></p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider">DPI / CUI</label>
                                    <p class="text-gray-900 font-mono" x-text="solicitud.cui"></p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider">Teléfono</label>
                                    <p class="text-gray-900" x-text="solicitud.telefono"></p>
                                </div>

                                <div class="sm:col-span-2 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider">Correo Electrónico</label>
                                <p class="text-gray-900 truncate" x-text="solicitud.email"></p>
                                </div>

                                <div class="sm:col-span-2 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider">Domicilio / Zona</label>
                                    <p class="text-gray-900 text-sm">
                                    <span x-text="solicitud.domicilio"></span> - <span class="font-bold text-blue-600" x-text="(solicitud.zona?.nombre || '')"></span>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                </div>
            </div>
        </div>
    </div>







   </div>

   
   </div>

</x-interno-layout>
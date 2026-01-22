<x-interno-layout :breadcrumb="[
   [
    'name' => 'Dashboard',
    'url' => route('interno.dashboard.index')
   ],
   [
    'name' => 'Visita de campo'
   ]
]">




<div class="flex gap-2 mb-4">
    <button
        @click="Livewire.dispatch('filtrar-visitas', { estado: 'Visita asignada' })"
        class="px-4 py-2 rounded-lg font-bold bg-gray-200 text-gray-700">
        Visita Asignada
    </button>

    <button
        @click="Livewire.dispatch('filtrar-visitas', { estado: 'Visita realizada' })"
        class="px-4 py-2 rounded-lg font-bold bg-gray-200 text-gray-700">
        Visita Realizada
    </button>
</div>

@livewire('visita-campo-table')
<div
    x-data="{
       
        openPreview: false,
        imgSource: '',
        imagenActiva:null,
        mostrarInput: true,
        fotosSeleccionadas: [],
        // guarda wire:id de componente livewire
        livewireId: null,
        init(){
            // espera a que todo el componente este renderizado
            this.$nextTick(() => {
               const el = document.querySelector('[wire\\:id]');
               if(el) {
                  this.livewireId = el.getAttribute('wire:id');
               }
            });
        },

        open: false,
        openVisitaAsignada: false,
        solicitud: {},
        openAceptar: false,
        step: 1,
        observaciones: '',

        initEditor() {
            // evitar crear multiples instancias
            if (window.visitaEditor) return;

            const el = document.querySelector('#editor');
            if (!el) return;

            ClassicEditor.create(el, {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'undo',
                        'redo'
                    ],
                    shouldNotGroupWhenFull: true
                },
                simpleUpload: {
                    uploadUrl: '{{ route('interno.visita-campo.upload') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            })
            .then(editor => {
                // guardar instancia global
                window.visitaEditor = editor;

                // ckeditor con alpine
                editor.model.document.on('change:data', () => {
                    this.observaciones = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
        }
    }"
    @preview-foto.window="openPreview = true; imgSource = $event.detail.url"



    x-on:visita-realizada.window="
        openVisitaAsignada = false;
        open = false;
        observaciones = '';
        if (window.visitaEditor) window.visitaEditor.setData('');
    "

    x-on:solicitud-por-autorizar.window="
        openAceptar = false;
        open = false;
    "

    x-init="
        $watch('step', value => {
            if (value === 2) {
                initEditor();
            }
        })
    "

    @open-modal-visita.window="
        open = true;
        solicitud = $event.detail.solicitud;
        step = 1;
    "
>


     
  
<!-- MODAL PARA ABRIR FOTO EN GRANDE -->
    <div
    x-show="openPreview"
    x-cloak
    @click="openPreview = false"
    class="fixed inset-0 z-[200] flex items-center justify-center
    bg-black bg-opacity-90 backdrop-blur-sm"
    @keydown.escape.window="openPreview = false"
    >
    <button @click="openPreview = false" class="absolute top-5
    right-5 text-white hover:text-red-400 transition-colors">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <img :src="imgSource"
     class="max-w-[95vw] max-h-[95vh] w-auto h-auto object-contain rounded-lg shadow-2xl"
>
    </div>

<!-- MODAL PARA CONFIRMAR VISITA DE CAMPO -->
<div x-show="openVisitaAsignada"
     x-cloak
     class="fixed inset-0 z-[60] flex items-center justify-center">

    <div class="fixed inset-0 bg-black bg-opacity-50"
    @click="openVisitaAsignada = false">
    </div>

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-green-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                        </svg>
                    <h3 class="text-lg font-bold text-gray-800">
                        Confirmar visita de campo
                    </h3>
                </div>

                <button @click="openVisitaAsignada = false"
                              type="button"
                              class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors duration-200 focus:outline-none"
                              aria-label="Cerrar modal">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                          </svg>
                </button>

              </div>

              <p class="font-bold text-blue-500 mt-2">
                    ¿Está seguro que desea confirmar esta visita de campo?
              </p>



                <div class="flex justify-end gap-3 mt-5">
                    <button
                    @click="openVisitaAsignada = false"
                    class="px-4 py-2 text-sm font-bold bg-gray-200 rounded-lg">
                    Cancelar
                    </button>

                    <button
                    @click="
                    Livewire.dispatch('visitaRealizada', {
                        id: solicitud.id,
                        observaciones: observaciones

                    });
                    " class="px-4 py-2 text-sm font-bold text-white rounded-lg
                    bg-teal-600"
                    >
                    Enviar visita de campo
                    </button>



                    </div>




    </div>
</div>



<!-- ABRIR MODAL PARA VISITA-->
<div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-md transition-opacity" @click="open = false"></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative transform overflow-hidden rounded-3xl bg-slate-50 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl p-0 border border-white">
            
            <div class="bg-gradient-to-r from-white via-blue-50/30 to-white px-8 py-6 border-b border-blue-100 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 leading-tight">
                            Solicitud <span class="text-blue-600">#<span x-text="solicitud.no_solicitud"></span></span>
                        </h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span>
                                <span x-text="solicitud.estado?.nombre || 'Estado pendiente'"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <button @click="open = false" class="group p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                    <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="bg-white/60 py-8 border-b border-blue-50">
                <div class="flex items-center justify-center max-w-md mx-auto relative">
                    <div class="flex flex-col items-center z-10">
                        <button @click="step = 1" 
                            :class="step >= 1 ? 'bg-blue-600 text-white shadow-blue-200 ring-4 ring-blue-50' : 'bg-slate-200 text-slate-500'" 
                            class="w-11 h-11 rounded-2xl font-black transition-all shadow-xl flex items-center justify-center text-lg">1</button>
                        <span class="mt-3 text-[11px] font-black uppercase tracking-widest" :class="step >= 1 ? 'text-blue-600' : 'text-slate-400'">Datos</span>
                    </div>
                    <div class="w-24 h-1.5 -mt-7 mx-1 rounded-full transition-colors overflow-hidden bg-slate-100">
                        <div class="h-full transition-all duration-500" :class="step > 1 ? 'w-full bg-blue-500' : 'w-0 bg-transparent'"></div>
                    </div>
                    <div class="flex flex-col items-center z-10">
                        <button @click="step = 2" 
                            :class="step >= 2 ? 'bg-blue-600 text-white shadow-blue-200 ring-4 ring-blue-50' : 'bg-white text-slate-400 border-2 border-slate-100'" 
                            class="w-11 h-11 rounded-2xl font-black transition-all shadow-lg flex items-center justify-center text-lg">2</button>
                        <span class="mt-3 text-[11px] font-black uppercase tracking-widest" :class="step >= 2 ? 'text-blue-600' : 'text-slate-400'">Visita</span>
                    </div>
                    <div class="w-24 h-1.5 -mt-7 mx-1 rounded-full transition-colors overflow-hidden bg-slate-100">
                        <div class="h-full transition-all duration-500" :class="step > 2 ? 'w-full bg-blue-500' : 'w-0 bg-transparent'"></div>
                    </div>
                    <div class="flex flex-col items-center z-10">
                        <button @click="step = 3" 
                            :class="step >= 3 ? 'bg-blue-600 text-white shadow-blue-200 ring-4 ring-blue-50' : 'bg-white text-slate-400 border-2 border-slate-100'" 
                            class="w-11 h-11 rounded-2xl font-black transition-all shadow-lg flex items-center justify-center text-lg">3</button>
                        <span class="mt-3 text-[11px] font-black uppercase tracking-widest" :class="step >= 3 ? 'text-blue-600' : 'text-slate-400'">Historial</span>
                    </div>
                </div>
            </div>

            <div class="p-8 max-h-[60vh] overflow-y-auto custom-scrollbar bg-white/40">
                
                <div x-show="step === 1" x-transition class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-slate-50 to-blue-50/30 rounded-[2rem] p-8 border border-blue-100/50 shadow-inner">
                        <div class="space-y-6">
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">Nombre Completo</label>
                                <p class="text-lg font-bold text-slate-800" x-text="solicitud.nombres + ' ' + (solicitud.apellidos || '')"></p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">DPI / CUI</label>
                                <p class="font-bold text-slate-700" x-text="solicitud.cui"></p>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">Email de contacto</label>
                                <p class="font-bold text-blue-600 underline decoration-blue-200" x-text="solicitud.email"></p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">Dirección Exacta</label>
                                <p class="font-bold text-slate-700" x-text="solicitud.domicilio"></p>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-1 bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">Zona</label>
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs font-black shadow-md shadow-blue-100" x-text="solicitud.zona?.nombre"></span>
                                </div>
                                <div class="flex-1 bg-white p-4 rounded-2xl shadow-sm border border-blue-50">
                                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] block mb-1">Trámite</label>
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-lg text-[10px] font-black border border-amber-200 uppercase" x-text="solicitud.requisitos_tramites?.[0]?.tramite?.nombre || 'General'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="step === 2" x-transition class="space-y-6">
                    <template x-if="solicitud.estado?.nombre === 'Visita asignada'">
                        <div class="space-y-6">
                            <div class="bg-white border-2 border-dashed border-blue-100 rounded-[2rem] p-8 shadow-sm">
                                <label class="flex items-center gap-3 font-black text-slate-800 mb-4 uppercase text-xs tracking-[0.2em]">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </div>
                                    Observaciones de Campo
                                </label>
                                <textarea id="editor" rows="4" 
                                    class="w-full bg-slate-50 rounded-2xl border-0 p-5 text-sm focus:ring-2 focus:ring-blue-500 transition-all shadow-inner placeholder:text-slate-400" 
                                    placeholder="Escriba aquí los hallazgos detallados de la visita..."></textarea>
                            </div>

                            <div class="bg-blue-50/50 rounded-[2rem] p-8 border border-blue-100 text-center">
                                <div x-show="mostrarInput" class="mb-6">
                                    <input type="file" accept=".jpg,.jpeg,.png,.webp" class="hidden" id="fileInput"
                                           @change="if (!livewireId) return; const file = $event.target.files[0]; Livewire.find(livewireId).upload('fotos', file, ()=> { fotosSeleccionadas.push({ url: URL.createObjectURL(file) }); }); mostrarInput = false;">
                                    <label for="fileInput" class="cursor-pointer inline-flex items-center gap-3 px-8 py-4 bg-blue-600 text-white rounded-2xl font-black shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" /></svg> SUBIR EVIDENCIA FOTOGRÁFICA
                                    </label>
                                </div>
                                <button x-show="!mostrarInput" @click="mostrarInput = true" class="text-blue-600 font-black hover:text-blue-800 text-xs uppercase tracking-widest">+ Agregar otra fotografía</button>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-8">
                                    <template x-for="(foto, index) in fotosSeleccionadas" :key="index">
                                        <div class="relative group aspect-square rounded-[1.5rem] overflow-hidden border-4 border-white shadow-lg">
                                            <img :src="foto.url" class="w-full h-full object-cover">
                                            <button @click="fotosSeleccionadas.splice(index, 1)" class="absolute top-3 right-3 p-2 bg-red-500 text-white rounded-xl opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="solicitud.estado?.nombre === 'Visita realizada'">
                        <div class="space-y-8">
                            <div class="bg-white rounded-[2rem] p-8 border border-blue-50 shadow-sm">
                                <h4 class="font-black text-slate-800 uppercase text-xs tracking-[0.2em] mb-6 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Resultado Detallado de Inspección
                                </h4>
                                <div class="space-y-4">
                                    <template x-for="bitacora in solicitud.bitacoras?.filter(b=> b.evento.includes('Visita realizada'))" :key="bitacora.id">
                                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                            <div x-html="bitacora.descripcion" class="text-sm text-slate-600 leading-relaxed italic"></div>
                                            <div class="flex items-center justify-between mt-4">
                                                <p class="text-[10px] text-blue-400 font-black uppercase tracking-widest" x-text="bitacora.fecha_formateada"></p>
                                                <span class="text-[10px] bg-white px-2 py-1 rounded-md text-slate-400 font-bold border border-slate-100">REPORTE OFICIAL</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <template x-for="foto in solicitud.fotos" :key="foto.id">
                                    <div class="group relative aspect-video rounded-[1.5rem] overflow-hidden cursor-zoom-in border-4 border-white shadow-md hover:shadow-2xl transition-all" 
                                         @click="$dispatch('preview-foto', { url: '/storage/' + foto.ruta })">
                                        <img :src="'/storage/' + foto.ruta" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="step === 3" x-transition>
                    <div class="relative pl-10 space-y-8 before:content-[''] before:absolute before:left-[15px] before:top-2 before:bottom-2 before:w-1 before:bg-gradient-to-b before:from-blue-200 before:to-transparent">
                        <template x-for="item in solicitud.bitacoras" :key="item.id">
                            <div class="relative group">
                                <div class="absolute -left-[32px] top-1 w-6 h-6 rounded-full border-4 border-white shadow-md z-10 transition-transform group-hover:scale-125" 
                                     :class="item.evento.includes('Aceptada') ? 'bg-green-500' : 'bg-blue-500'"></div>
                                <div class="bg-white border border-blue-50 rounded-[1.5rem] p-5 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="px-3 py-1 bg-slate-50 text-blue-700 rounded-lg text-[11px] font-black uppercase tracking-tighter border border-blue-50" x-text="item.evento"></span>
                                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded" x-text="item.fecha_formateada"></span>
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed" x-text="item.descripcion"></p>
                                    <div class="flex items-center mt-4 pt-4 border-t border-slate-50">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-xs font-black text-slate-600 mr-3 shadow-inner" x-text="item.user.name.charAt(0)"></div>
                                        <span class="text-[11px] font-black text-slate-500 uppercase tracking-widest" x-text="item.user.name"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-white border-t border-slate-100 flex items-center justify-between">
                <button x-show="step > 1" @click="step--" class="flex items-center gap-2 px-6 py-3 text-sm font-black text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg> VOLVER
                </button>
                <div class="flex-1"></div>
                
                <button x-show="step < 3" @click="step++" class="group flex items-center gap-3 px-10 py-3 bg-slate-800 text-white text-sm font-black rounded-2xl hover:bg-slate-900 transition-all shadow-xl shadow-slate-200">
                    SIGUIENTE <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </button>

                <div class="flex gap-4">
                    <button x-show="step === 3 && solicitud.estado?.nombre === 'Visita asignada'" @click="openVisitaAsignada = true" 
                            class="px-10 py-3 bg-teal-500 text-white text-sm font-black rounded-2xl hover:bg-teal-600 shadow-xl shadow-teal-200 transition-all active:scale-95">
                        ENVIAR VISITA DE CAMPO
                    </button>

                    <button x-show="step === 3 && solicitud.estado?.nombre === 'Visita realizada'" @click="openAceptar = true"
                            class="px-10 py-3 bg-blue-600 text-white text-sm font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all active:scale-95">
                        FINALIZAR Y ACEPTAR
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



   
<!-- MODAL DE ACEPTAR -->

  <div x-show="openAceptar" x-cloak class="fixed inset-0 z-60
  flex items-center justify-center">

      <div
        class="fixed inset-0 bg-black bg-opacity-50"
        @click="openAceptar = false"
      ></div>

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">



      <div class="flex items-center justify-between">



         <div class="flex items-center gap-2">






     <svg xmlns="http://www.w3.org/2000/svg"
     class="h-6 w-6 text-green-600"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
    </svg>



        <h3 class="text-lg font-bold text-gray-800">
            Aceptar Solicitud
        </h3>
    </div>


      <button @click="openAceptar = false"
                              type="button"
                              class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors duration-200 focus:outline-none"
                              aria-label="Cerrar modal">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                          </svg>
      </button>



      </div>


      <p class="font-bold text-blue-500 mt-2">
        ¿Está seguro que desea aceptar está solicitud?
      </p>


       <div class="flex justify-end gap-3 mt-5">
      <button
      @click="openAceptar = false"
      class="px-4 py-2 text-sm font-bold bg-gray-200 rounded-lg">
      Cancelar
      </button>

      <button
        @click="
        openAceptar = false;
        open = false;
        Livewire.dispatch('peticionPorAutorizar', { id: solicitud.id });
    "
        class="px-4 py-2 text-sm font-bold text-white rounded-lg bg-green-600"
    >
        Aceptar solicitud
    </button>

    </div>

    </div>
    
</div>


</div>






<!-- NUEVO MODAL -->
  


</div>



</x-interno-layout>





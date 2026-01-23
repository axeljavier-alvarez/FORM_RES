<div
    x-data="{
        openModal: false
    }"
    x-effect="
        if (@js($solicitud)) {
            openModal = true
        }
    "
    class="px-4 py-12 -mt-5 bg-slate-50 min-h-screen"
>

    {{-- CONTENEDOR PRINCIPAL --}}
    <div class="max-w-3xl mx-auto p-4 md:p-8">

        {{-- FORMULARIO --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            <div class="p-8 md:p-10">

                {{-- TÍTULO --}}
                <h1 class="tracking-widest text-2xl md:text-3xl text-[#030EA7] text-center mb-4">
                    VER ESTADO DE MI CONSTANCIA
                </h1>

                {{-- ALERTA --}}
                <p class="mb-8 text-red-600 text-center text-sm bg-yellow-100 p-2 rounded">
                    Debe ingresar los datos que colocó en su solicitud
                </p>

                {{-- ICONO --}}
                <img
                    src="{{ asset('imagenes/icono_muni.png') }}"
                    alt="Icono"
                    class="w-24 md:w-32 mx-auto block mb-10 drop-shadow-md"
                >

                {{-- INPUTS --}}
                <div class="max-w-xl mx-auto space-y-8">

                    <div>
                        <label class="block font-bold text-center text-green-600">
                            Número de DPI/CUI
                        </label>
                        <input
                            type="text"
                            wire:model.defer="cui"
                            placeholder="Ingrese su número de DPI/CUI"
                            class="w-full bg-slate-50 border-b-2 border-slate-200 px-1 py-3 text-center text-slate-700 font-bold focus:border-[#030EA7] focus:bg-white transition-all outline-none"
                        >
                    </div>

                    <div>
                        <label class="block font-bold text-center text-green-600">
                            Número de solicitud
                        </label>
                        <input
                            type="text"
                            wire:model.defer="no_solicitud"
                            placeholder="Ingrese su número de solicitud"
                            class="w-full bg-slate-50 border-b-2 border-slate-200 px-1 py-3 text-center text-slate-700 font-bold focus:border-[#030EA7] focus:bg-white transition-all outline-none"
                        >
                    </div>

                </div>

                {{-- ERROR --}}
                @if ($error)
                    <p class="mt-8 text-center text-red-600 font-black text-sm bg-red-50 p-3 rounded-xl border border-red-100 uppercase">
                        {{ $error }}
                    </p>
                @endif

                {{-- BOTONES --}}
                <div class="max-w-xl mx-auto mt-12 flex flex-col md:flex-row gap-4">
                    <button
                        wire:click="consultar"
                        class="w-full md:w-1/2 bg-[#03192B] hover:bg-[#03192B]/90 text-white font-black py-4 rounded-xl shadow-lg transition-all active:scale-95 uppercase tracking-widest text-sm"
                    >
                        Consultar
                    </button>

                    <button
                        wire:click="limpiar"
                        type="button"
                        class="w-full md:w-1/2 bg-[#F1F5F9] hover:bg-[#757575]/90 text-black font-black py-4 rounded-xl transition-all active:scale-95 uppercase tracking-widest text-sm"
                    >
                        Limpiar
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div
        x-show="openModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
    >

        {{-- OVERLAY --}}
        <div
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
           @click="
                openModal = false;
                $wire.limpiarSolicitud();
            "
        ></div>

        {{-- CONTENIDO --}}
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="font-black text-[#03192B] uppercase tracking-widest text-sm">
                    Resultado de la consulta
                </h3>
                <button
                    @click="
                        openModal = false;
                        $wire.limpiarSolicitud();
                    "
                    class="text-slate-400 hover:text-black text-xl font-black"
                >
                    ×
                </button>
            </div>

            {{-- BODY --}}
            @if ($solicitud)
                <div class="p-6 space-y-6">

                    {{-- ESTADO ACTUAL --}}
                    <div class="bg-white rounded-2xl shadow border border-slate-100">
                        <h3 class="text-center text-sm font-black bg-[#83BD3F] text-white py-4 uppercase tracking-[0.2em]">
                            Estado actual de su constancia
                        </h3>

                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-xs font-black text-slate-400 uppercase">Solicitante</span>
                                <span class="font-bold uppercase">
                                    {{ $solicitud->nombres }} {{ $solicitud->apellidos }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-xs font-black text-slate-400 uppercase">Estado</span>
                                <span class="font-black uppercase text-blue-600">
                                    {{ $solicitud->estado->nombre }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- PROCESO --}}
                    <div class="bg-slate-900 rounded-2xl shadow-2xl p-8 text-white">
                        <h3 class="text-center text-[10px] font-black uppercase tracking-[0.3em] mb-10 text-slate-500">
                            Progreso del proceso
                        </h3>

                        <div class="flex flex-col md:flex-row justify-between gap-8">
                            @foreach($estados as $index => $estado)
                                @php
                                    $completado = $estado->id <= $solicitud->estado_id;
                                @endphp

                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                                        {{ $completado ? 'bg-[#83BD3F]' : 'bg-slate-700' }}">
                                        @if($completado)
                                            ✓
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>

                                    <span class="text-[10px] font-black uppercase text-center
                                        {{ $completado ? 'text-white' : 'text-slate-500' }}">
                                        {{ $estado->nombre }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>

</div>

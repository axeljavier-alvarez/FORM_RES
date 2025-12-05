<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class SolicitudForm extends Component
{
    // campos del formulario
    public $no_solicitud;
    public $anio;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $cui;
    public $domicilio;
    public $observaciones;

    // para mostrar toasts (se entangla con Alpine)
    public $toast = null;

    protected $rules = [
        'nombre' => 'required|string|max:60',
        'apellido' => 'required|string|max:60',
        'email' => 'required|email|max:45',
        'telefono' => 'required|string|max:20',
        'cui' => 'required|string|size:13',
        'domicilio' => 'required|string|max:255',
        'observaciones' => 'nullable|string|max:255',
    ];

    // mensajes personalizados opcional
    protected $messages = [
        'cui.size' => 'El CUI debe tener exactamente 13 caracteres.',
        'email.email' => 'El email no tiene formato válido.',
    ];

    public function mount()
    {
        // valor inicial del año
        $this->anio = now()->year;
    }

    // validación en tiempo real por campo
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        // valida todo
        $validated = $this->validate();

        // Forzar año actual (evita manipulación)
        $validated['anio'] = now()->year;

        // Usar transacción para evitar inconsistencias
        DB::beginTransaction();
        try {
            // crear sin no_solicitud
            $solicitud = Solicitud::create($validated);

            // actualizar no_solicitud con el id
            $solicitud->update([
                'no_solicitud' => $solicitud->id . '-' . $solicitud->anio
            ]);

            DB::commit();

            // limpiar inputs
            $this->reset(['nombre','apellido','email','telefono','cui','domicilio','observaciones']);

            // actualizar año por si cambió
            $this->anio = now()->year;

            // configurar toast (se refleja en la vista vía entangle)
            $this->toast = [
                'type' => 'success',
                'message' => 'Solicitud enviada correctamente'
            ];

            // opcional: emitir evento para javascript o listeners
            $this->dispatchBrowserEvent('solicitud-guardada', ['id' => $solicitud->id]);

        } catch (\Throwable $e) {
            DB::rollBack();

            $this->toast = [
                'type' => 'danger',
                'message' => 'Error al guardar, inténtalo de nuevo.'
            ];

            // opcional log
            // logger($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.solicitud-form');
    }
}

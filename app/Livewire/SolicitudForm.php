<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Solicitud;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class SolicitudForm extends Component
{

    // campos del form
    public $no_solicitud;
    public $anio;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $cui;
    public $domicilio;
    public $observaciones;

    // luego mostrar toast de alpine
    public $toast = null;
    public function rules (){

        return [
        'nombre' => 'required|string|max:60',
        'apellido' => 'required|string|max:60',
        'email' => [
            'required',
            'email',
            'max:45',
            Rule::unique('solicitudes', 'email')
        ],
        

        'telefono' => 'required|string|max:20',
        'cui' => [
            'required',
            'string',
            'size:13',
            Rule::unique('solicitudes', 'cui')
        ],
        'domicilio' => 'required|string|max:255',
        'observaciones' => 'nullable|string|max:255'
    ];
      
    }
        
   

    protected $messages = [
        'cui.size' => 'El cui debe tener 13 caracteres.',
        'email.email' => 'El email no tiene formato válido',
        'email.unique' => 'Ya existe una solicitud con el correo :input',
        'cui.unique' => 'Ya existe una solicitud con el cui :input'
    ];

    public function mount()
    {
        $this->anio = now()->year;
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function submit()
    {
        $validated = $this->validate($this->rules());

        $validated['anio'] = now()->year;

        // dd($validated);

        DB::beginTransaction();
        try{
            $solicitud = Solicitud::create($validated);
            $solicitud->no_solicitud = $solicitud->id . '-' . $solicitud->anio;
            $solicitud->save();
            DB::commit();
            $this->resetExcept('anio');
            $this->toast=[
                'type' => 'success',
                'message' => 'Solicitud enviada correctamente'
            ];
        }catch(\Throwable $e){
            DB::rollBack();

            dd($e->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.solicitud-form');
    }
}

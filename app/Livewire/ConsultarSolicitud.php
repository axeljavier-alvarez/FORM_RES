<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Estado;


class ConsultarSolicitud extends Component
{
    

    public $cui;

    public $no_solicitud;

    public $solicitud;

    public $estados;

    public $error;


    // funcion para consultar

    public function consultar()
    {
        $this->reset(['solicitud', 'error']);

        // ambos campos vacios
        if(empty($this->cui) && empty($this->no_solicitud)){
            $this->error = 'Debe ingresar los datos para poder consultar su solicitud';
            return;
        }

        if(empty($this->cui) || empty($this->no_solicitud)){
                    $this->error = 'Debe completar ambos campos para poder consultar su solicitud.';
                    return;
        }
        // validar campos 
        $this->validate([
            'cui' => 'required',
            'no_solicitud' => 'required'
        ]);

        // solicitud con estado 
        $this->solicitud = Solicitud::with
        ([
            'estado',
            'requisitosTramites.tramite'
        ])
        ->where('cui', $this->cui)
        ->where('no_solicitud', $this->no_solicitud)
        ->first();

        // en caso de error
        if(!$this->solicitud){
            $this->error = 'Los datos ingresados no coinciden con ninguna solicitud.';
            return;
        }

        // mostrar todos los estados
        $this->estados = Estado::all();
    }

    public function limpiar()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.consultar-solicitud');
    }

}

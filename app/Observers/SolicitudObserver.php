<?php

namespace App\Observers;

use App\Models\Solicitud;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use App\Models\Estado;

class SolicitudObserver
{
    /**
     * Handle the Solicitud "created" event.
     */
    public function created(Solicitud $solicitud): void
    {
        Bitacora::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => null,
            'evento' => 'CREACION',
            'descripcion' => 'Solicitud creada exitosamente desde el formulario.'
        ]);
    }

    /**
     * Handle the Solicitud "updated" event.
     */
    public function updated(Solicitud $solicitud): void
    {
        // registrar bitacora si cambio el estado
        if($solicitud->isDirty('estado_id')){
            $nuevoEstado = Estado::find($solicitud->estado_id);
            $nombreEstado = $nuevoEstado ? $nuevoEstado->nombre : 'DESCONOCIDO';

            // $descripcion = "El estado de la solicitud cambió a: " . $nombreEstado;

            // if($nombreEstado === 'Cancelado'){
            //     $descripcion = "La solicitud ha sido rechazada por el analista";
            // } elseif ($nombreEstado === 'En proceso'){
            //     $descripcion = "la solicitud esta en proceso para análisis";
            // } 

            


            $descripcion = match ($nombreEstado) {
        'Cancelado' => $solicitud->observaciones
            ? 'Solicitud rechazada. Motivo: ' . $solicitud->observaciones
            : 'Solicitud rechazada sin observaciones.',
        'En proceso' => 'La solicitud está en proceso para análisis.',
        default => 'Cambio de estado a: ' . $nombreEstado,
    };



            Bitacora::create([
                'solicitud_id' => $solicitud->id,
                'user_id' => Auth::id(),
                'evento' => 'CAMBIO DE ESTADO: ' . $nombreEstado,
                'descripcion' => $descripcion
            ]);
        }
    }

    /**
     * Handle the Solicitud "deleted" event.
     */
    public function deleted(Solicitud $solicitud): void
    {
        //
    }

    /**
     * Handle the Solicitud "restored" event.
     */
    public function restored(Solicitud $solicitud): void
    {
        //
    }

    /**
     * Handle the Solicitud "force deleted" event.
     */
    public function forceDeleted(Solicitud $solicitud): void
    {
        //
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{

    protected $table = 'solicitudes';

    // DATOS DE SOLICITUDES
    protected $fillable = [
        'no_solicitud',
        'anio',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'cui',
        'domicilio',
        'observaciones'
    ];

}

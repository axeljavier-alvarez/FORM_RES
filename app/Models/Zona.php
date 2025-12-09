<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nombre'];

    // zona que tiene varias solicitudes
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'zona_id');
    }
}

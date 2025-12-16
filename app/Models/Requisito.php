<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{

    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['nombre', 'slug'];

    public function tramites()
    {
        return $this->belongsToMany(
            Tramite::class,
            'requisito_tramite',
            'requisito_id',
            'tramite_id'
        );
    }
}

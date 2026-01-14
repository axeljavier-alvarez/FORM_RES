<?php

namespace Database\Seeders;
use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

           // DB::table('estados')->truncate();


    $estados = [
    'Pendiente',          // Recién creada, sin asignación
    'En proceso',         // En revisión administrativa
    'Visita asignada',    // Ya tiene visita de campo programada
    'Visita realizada',  // Ya se hizo la visita
    'Completado',         // Trámite finalizado
    'Cancelado'
    ];


    foreach($estados as $nombre){

        Estado::firstOrCreate(['nombre' => $nombre]);
    }

    }
}

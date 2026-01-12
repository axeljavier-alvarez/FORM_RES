<?php

namespace Database\Seeders;
use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

   $estados = ['Pendiente', 'En proceso', 'Visita de Campo', 'Completado', 'Cancelado'];

    foreach($estados as $nombre){
        
        Estado::firstOrCreate(['nombre' => $nombre]);
    }

    }
}

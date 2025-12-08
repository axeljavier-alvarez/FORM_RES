<?php

namespace Database\Seeders;
use App\Models\Tramite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $tramites = [
            'Magisterio', 
            'Solicitar DPI al Registro Nacional de las Personas',
            'Inscripción extemporánea de un menor de edad ante el Registro Nacional de las Personas',
            'Inscripción extemporánea de un mayor de edad ante el Registro Nacional de las Personas',
            'Tramites legales en materia civil',
            'Tramites legales en materia penal'
        ];

        foreach($tramites as $nombre){
            Tramite::create(['nombre' => $nombre]);
        }
    }

}

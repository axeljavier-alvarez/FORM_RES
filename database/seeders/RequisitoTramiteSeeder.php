<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tramite;

class RequisitoTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // asignar a cada tramite los requisitos necesarios
        Tramite::find(1)->requisitos()->sync([1,2,3,4,5,6]);
        Tramite::find(2)->requisitos()->sync([1,8,2,3]);
        Tramite::find(3)->requisitos()->sync([1,4,2,3,9,3]); 
        Tramite::find(4)->requisitos()->sync([1,10,2,3]);
        Tramite::find(5)->requisitos()->sync([1,4,2,3,6,8,10]);
        Tramite::find(6)->requisitos()->sync([1,4,11,2,3,12,8]);

    }
}

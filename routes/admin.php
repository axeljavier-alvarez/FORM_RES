<?php

use Illuminate\Support\Facades\Route;


Route::get('ver-consultas', function(){
    return view ('consulta.index');
})->name('consulta.index');
<?php

use App\Http\Controllers\Interno\AnalisisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Interno\SolicitudController;
use App\Http\Controllers\Interno\VisitaCampoController;

Route::get('ver-consultas', function(){
    return view ('interno.index');
})->name('consulta.index');


Route::resource('solicitudes', SolicitudController::class);
Route::resource('analisis', AnalisisController::class);
Route::resource('visita-campo', VisitaCampoController::class);

Route::post('visita-campo/upload', [VisitaCampoController::class, 'upload'])
     ->name('visita-campo.upload');

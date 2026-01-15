<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. verificar si la columna ya existe
        if (!Schema::hasColumn('detalle_solicitud', 'user_id')) {
            DB::statement('ALTER TABLE detalle_solicitud ADD COLUMN user_id BIGINT UNSIGNED NULL');
        }

        // Crear llave foranea
        try {
            DB::statement('ALTER TABLE detalle_solicitud 
                           ADD CONSTRAINT fk_detalle_solicitud_user 
                           FOREIGN KEY (user_id) REFERENCES users(id) 
                           ON DELETE SET NULL');
        } catch (\Exception $e) {
            // Si ya existe la relación, simplemente ignoramos el error y continuamos
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Eliminar relacion si existe
        try {
            DB::statement('ALTER TABLE detalle_solicitud DROP FOREIGN KEY fk_detalle_solicitud_user');
        } catch (\Exception $e) {}

        //Eliminar columna
        if (Schema::hasColumn('detalle_solicitud', 'user_id')) {
            DB::statement('ALTER TABLE detalle_solicitud DROP COLUMN user_id');
        }
    }
};
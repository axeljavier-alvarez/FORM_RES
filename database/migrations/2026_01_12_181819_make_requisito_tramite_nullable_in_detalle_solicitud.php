<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        // Cambiar la columna existente a nullable
        DB::statement('ALTER TABLE detalle_solicitud MODIFY requisito_tramite_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        // Volver a NOT NULL
        DB::statement('ALTER TABLE detalle_solicitud MODIFY requisito_tramite_id BIGINT UNSIGNED NOT NULL');
    }
};

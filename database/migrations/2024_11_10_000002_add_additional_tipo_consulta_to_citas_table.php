<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // En MySQL, modificar un ENUM requiere reconstruir la columna
        DB::statement("ALTER TABLE citas MODIFY COLUMN tipo_consulta ENUM(
            'consulta_general',
            'vacunacion',
            'cirugia',
            'control',
            'emergencia',
            'urgencia',
            'peluqueria'
        ) DEFAULT 'consulta_general'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volver al ENUM original
        DB::statement("ALTER TABLE citas MODIFY COLUMN tipo_consulta ENUM(
            'consulta_general',
            'vacunacion',
            'cirugia',
            'control',
            'emergencia'
        ) DEFAULT 'consulta_general'");
    }
};

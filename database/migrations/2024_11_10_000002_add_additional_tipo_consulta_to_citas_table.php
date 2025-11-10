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
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL: Modificar el CHECK constraint
            // Primero eliminamos el constraint existente
            DB::statement("ALTER TABLE citas DROP CONSTRAINT IF EXISTS citas_tipo_consulta_check");

            // Agregamos el nuevo constraint con los valores adicionales
            DB::statement("ALTER TABLE citas ADD CONSTRAINT citas_tipo_consulta_check
                CHECK (tipo_consulta::text = ANY (ARRAY[
                    'consulta_general'::character varying,
                    'vacunacion'::character varying,
                    'cirugia'::character varying,
                    'control'::character varying,
                    'emergencia'::character varying,
                    'urgencia'::character varying,
                    'peluqueria'::character varying
                ]::text[]))");
        } elseif ($driver === 'mysql') {
            // MySQL: Modificar la columna ENUM
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
        // SQLite no soporta ENUM nativamente, no hace nada
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL: Volver al constraint original
            DB::statement("ALTER TABLE citas DROP CONSTRAINT IF EXISTS citas_tipo_consulta_check");

            DB::statement("ALTER TABLE citas ADD CONSTRAINT citas_tipo_consulta_check
                CHECK (tipo_consulta::text = ANY (ARRAY[
                    'consulta_general'::character varying,
                    'vacunacion'::character varying,
                    'cirugia'::character varying,
                    'control'::character varying,
                    'emergencia'::character varying
                ]::text[]))");
        } elseif ($driver === 'mysql') {
            DB::statement("ALTER TABLE citas MODIFY COLUMN tipo_consulta ENUM(
                'consulta_general',
                'vacunacion',
                'cirugia',
                'control',
                'emergencia'
            ) DEFAULT 'consulta_general'");
        }
        // SQLite: No hace nada
    }
};

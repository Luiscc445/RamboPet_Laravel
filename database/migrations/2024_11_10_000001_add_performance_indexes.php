<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agrega índices optimizados para PostgreSQL
     */
    public function up(): void
    {
        // Índices compuestos para citas (queries más comunes)
        Schema::table('citas', function (Blueprint $table) {
            $table->index(['mascota_id', 'estado', 'fecha_hora']);
            $table->index(['veterinario_id', 'fecha_hora']);
            $table->index(['estado', 'fecha_hora']);
        });

        // Índices para mascotas
        Schema::table('mascotas', function (Blueprint $table) {
            $table->index(['tutor_id', 'activo']);
            $table->index(['especie_id', 'raza_id']);
            $table->index('activo');
        });

        // Índices para productos (inventario)
        Schema::table('productos', function (Blueprint $table) {
            $table->index(['categoria', 'activo']);
            $table->index('activo');
        });

        // Índices para lotes
        Schema::table('lotes', function (Blueprint $table) {
            $table->index(['producto_id', 'fecha_vencimiento']);
            $table->index('fecha_vencimiento');
        });

        // Índices para movimientos de inventario
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->index(['producto_id', 'fecha']);
            $table->index(['lote_id', 'fecha']);
            $table->index('fecha');
        });

        // Índice para users (búsquedas por email y rol)
        Schema::table('users', function (Blueprint $table) {
            $table->index(['rol', 'activo']);
            $table->index('activo');
        });

        // Índice para tutores
        Schema::table('tutores', function (Blueprint $table) {
            $table->index('activo');
        });

        // Optimización específica de PostgreSQL: ANALYZE para actualizar estadísticas
        DB::statement('ANALYZE citas');
        DB::statement('ANALYZE mascotas');
        DB::statement('ANALYZE productos');
        DB::statement('ANALYZE users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropIndex(['mascota_id', 'estado', 'fecha_hora']);
            $table->dropIndex(['veterinario_id', 'fecha_hora']);
            $table->dropIndex(['estado', 'fecha_hora']);
        });

        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropIndex(['tutor_id', 'activo']);
            $table->dropIndex(['especie_id', 'raza_id']);
            $table->dropIndex(['activo']);
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropIndex(['categoria', 'activo']);
            $table->dropIndex(['activo']);
        });

        Schema::table('lotes', function (Blueprint $table) {
            $table->dropIndex(['producto_id', 'fecha_vencimiento']);
            $table->dropIndex(['fecha_vencimiento']);
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropIndex(['producto_id', 'fecha']);
            $table->dropIndex(['lote_id', 'fecha']);
            $table->dropIndex(['fecha']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['rol', 'activo']);
            $table->dropIndex(['activo']);
        });

        Schema::table('tutores', function (Blueprint $table) {
            $table->dropIndex(['activo']);
        });
    }
};

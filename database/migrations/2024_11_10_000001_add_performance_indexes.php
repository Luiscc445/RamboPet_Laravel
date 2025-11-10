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
     * Solo crea índices que NO existen en las migraciones originales
     */
    public function up(): void
    {
        // Índices compuestos para citas (queries más comunes)
        Schema::table('citas', function (Blueprint $table) {
            $table->index(['mascota_id', 'estado', 'fecha_hora'], 'citas_mascota_estado_fecha_idx');
            $table->index(['veterinario_id', 'fecha_hora'], 'citas_veterinario_fecha_idx');
            $table->index(['estado', 'fecha_hora'], 'citas_estado_fecha_idx');
        });

        // Índices para mascotas
        Schema::table('mascotas', function (Blueprint $table) {
            $table->index(['tutor_id', 'activo'], 'mascotas_tutor_activo_idx');
            $table->index(['especie_id', 'raza_id'], 'mascotas_especie_raza_idx');
            $table->index('activo', 'mascotas_activo_idx');
        });

        // Índices para productos (inventario)
        // NOTA: 'categoria' y 'stock_actual' ya existen en migración original
        Schema::table('productos', function (Blueprint $table) {
            $table->index(['categoria', 'activo'], 'productos_categoria_activo_idx');
            $table->index('activo', 'productos_activo_idx');
        });

        // Índices para lotes
        // NOTA: 'fecha_vencimiento' ya existe en migración original
        Schema::table('lotes', function (Blueprint $table) {
            $table->index(['producto_id', 'fecha_vencimiento'], 'lotes_producto_vencimiento_idx');
        });

        // Índices para movimientos de inventario
        // NOTA: 'fecha_movimiento' ya existe en migración original
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->index(['producto_id', 'fecha_movimiento'], 'movimientos_producto_fecha_idx');
            $table->index(['lote_id', 'fecha_movimiento'], 'movimientos_lote_fecha_idx');
        });

        // Índice para users (búsquedas por email y rol)
        Schema::table('users', function (Blueprint $table) {
            $table->index(['rol', 'activo'], 'users_rol_activo_idx');
            $table->index('activo', 'users_activo_idx');
        });

        // Índice para tutores
        Schema::table('tutores', function (Blueprint $table) {
            $table->index('activo', 'tutores_activo_idx');
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
            $table->dropIndex('citas_mascota_estado_fecha_idx');
            $table->dropIndex('citas_veterinario_fecha_idx');
            $table->dropIndex('citas_estado_fecha_idx');
        });

        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropIndex('mascotas_tutor_activo_idx');
            $table->dropIndex('mascotas_especie_raza_idx');
            $table->dropIndex('mascotas_activo_idx');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropIndex('productos_categoria_activo_idx');
            $table->dropIndex('productos_activo_idx');
        });

        Schema::table('lotes', function (Blueprint $table) {
            $table->dropIndex('lotes_producto_vencimiento_idx');
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropIndex('movimientos_producto_fecha_idx');
            $table->dropIndex('movimientos_lote_fecha_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_rol_activo_idx');
            $table->dropIndex('users_activo_idx');
        });

        Schema::table('tutores', function (Blueprint $table) {
            $table->dropIndex('tutores_activo_idx');
        });
    }
};

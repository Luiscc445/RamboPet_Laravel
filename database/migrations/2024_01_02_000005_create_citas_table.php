<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('veterinario_id')->nullable()->constrained('users');
            $table->enum('tipo_consulta', [
                'consulta_general',
                'vacunacion',
                'cirugia',
                'control',
                'emergencia'
            ])->default('consulta_general');
            $table->dateTime('fecha_hora');
            $table->integer('duracion_minutos')->default(30);
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'en_curso',
                'completada',
                'cancelada',
                'perdida'
            ])->default('pendiente');
            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('recordatorio_enviado')->default(false);
            $table->boolean('confirmada')->default(false);
            $table->foreignId('creado_por')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index('fecha_hora');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

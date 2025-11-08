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
        Schema::create('episodios_clinicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('cita_id')->nullable()->constrained('citas');
            $table->foreignId('veterinario_id')->constrained('users');
            $table->dateTime('fecha');
            $table->text('motivo_consulta');
            $table->text('anamnesis')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->json('examenes_solicitados')->nullable();
            $table->json('procedimientos')->nullable();
            $table->json('medicamentos')->nullable();
            $table->date('proxima_visita')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['abierto', 'cerrado'])->default('abierto');
            $table->timestamps();
            $table->softDeletes();

            $table->index('fecha');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodios_clinicos');
    }
};

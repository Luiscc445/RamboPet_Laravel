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
        Schema::create('examenes_laboratorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('episodio_clinico_id')->constrained('episodios_clinicos')->onDelete('cascade');
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('veterinario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('laboratorista_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('tipo_examen'); // hemograma, bioquimica, urianálisis, etc.
            $table->text('indicaciones')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente');
            $table->enum('prioridad', ['normal', 'urgente', 'stat'])->default('normal');

            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_toma_muestra')->nullable();
            $table->dateTime('fecha_resultado')->nullable();

            $table->json('resultados')->nullable(); // Almacena los valores de laboratorio
            $table->text('interpretacion')->nullable(); // Interpretación del laboratorista
            $table->text('observaciones')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('estado');
            $table->index('tipo_examen');
            $table->index(['laboratorista_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes_laboratorio');
    }
};

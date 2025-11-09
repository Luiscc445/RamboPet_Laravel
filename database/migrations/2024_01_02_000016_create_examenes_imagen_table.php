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
        Schema::create('examenes_imagen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('episodio_clinico_id')->constrained('episodios_clinicos')->onDelete('cascade');
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('veterinario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ecografista_id')->nullable()->constrained('users')->onDelete('set null');

            $table->enum('tipo_examen', ['ecografia', 'radiografia', 'tomografia', 'resonancia'])->default('ecografia');
            $table->string('region_anatomica'); // abdomen, torax, extremidades, etc.
            $table->text('indicaciones')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado', 'cancelado'])->default('pendiente');
            $table->enum('prioridad', ['normal', 'urgente', 'stat'])->default('normal');

            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_realizacion')->nullable();
            $table->dateTime('fecha_informe')->nullable();

            $table->json('archivos_imagenes')->nullable(); // URLs de las imágenes subidas
            $table->text('hallazgos')->nullable(); // Descripción de hallazgos
            $table->text('conclusion')->nullable(); // Conclusión del estudio
            $table->text('recomendaciones')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('estado');
            $table->index('tipo_examen');
            $table->index(['ecografista_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes_imagen');
    }
};

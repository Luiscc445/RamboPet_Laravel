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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutores')->onDelete('cascade');
            $table->foreignId('especie_id')->constrained('especies');
            $table->foreignId('raza_id')->nullable()->constrained('razas');
            $table->string('nombre');
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['macho', 'hembra'])->default('macho');
            $table->string('color')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('microchip')->unique()->nullable();
            $table->boolean('esterilizado')->default(false);
            $table->text('alergias')->nullable();
            $table->text('condiciones_medicas')->nullable();
            $table->text('notas')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};

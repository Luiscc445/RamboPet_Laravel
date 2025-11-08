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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
            $table->enum('tipo_movimiento', [
                'entrada',
                'salida',
                'ajuste',
                'merma',
                'vencimiento'
            ]);
            $table->integer('cantidad');
            $table->dateTime('fecha_movimiento');
            $table->string('referencia_tipo')->nullable(); // Tipo de modelo relacionado (Cita, EpisodioClinico, etc.)
            $table->unsignedBigInteger('referencia_id')->nullable(); // ID del modelo relacionado
            $table->foreignId('usuario_id')->constrained('users');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('fecha_movimiento');
            $table->index('tipo_movimiento');
            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};

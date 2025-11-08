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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('numero_lote');
            $table->date('fecha_ingreso');
            $table->date('fecha_vencimiento');
            $table->integer('cantidad_inicial');
            $table->integer('cantidad_disponible');
            $table->string('proveedor')->nullable();
            $table->decimal('precio_compra_unitario', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['producto_id', 'numero_lote']);
            $table->index('fecha_vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};

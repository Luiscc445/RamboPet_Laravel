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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('categoria', [
                'medicamento',
                'vacuna',
                'alimento',
                'accesorio',
                'insumo'
            ])->default('medicamento');
            $table->string('unidad_medida')->default('unidad');
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(5);
            $table->integer('stock_maximo')->default(100);
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);
            $table->boolean('requiere_receta')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('categoria');
            $table->index('stock_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

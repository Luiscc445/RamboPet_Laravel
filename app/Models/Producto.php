<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria',
        'unidad_medida',
        'stock_actual',
        'stock_minimo',
        'stock_maximo',
        'precio_compra',
        'precio_venta',
        'requiere_receta',
        'activo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stock_actual' => 'integer',
            'stock_minimo' => 'integer',
            'stock_maximo' => 'integer',
            'precio_compra' => 'decimal:2',
            'precio_venta' => 'decimal:2',
            'requiere_receta' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    /**
     * Categorías de productos.
     */
    const CATEGORIA_MEDICAMENTO = 'medicamento';
    const CATEGORIA_VACUNA = 'vacuna';
    const CATEGORIA_ALIMENTO = 'alimento';
    const CATEGORIA_ACCESORIO = 'accesorio';
    const CATEGORIA_INSUMO = 'insumo';

    /**
     * Lotes de este producto.
     */
    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    /**
     * Movimientos de inventario de este producto.
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    /**
     * Verificar si el stock está bajo el mínimo.
     */
    public function getStockBajoAttribute(): bool
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    /**
     * Lotes vigentes (no vencidos).
     */
    public function lotesVigentes()
    {
        return $this->hasMany(Lote::class)
            ->where('fecha_vencimiento', '>', now())
            ->where('cantidad_disponible', '>', 0);
    }
}

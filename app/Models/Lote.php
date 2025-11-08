<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'producto_id',
        'numero_lote',
        'fecha_ingreso',
        'fecha_vencimiento',
        'cantidad_inicial',
        'cantidad_disponible',
        'proveedor',
        'precio_compra_unitario',
        'observaciones',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'fecha_vencimiento' => 'date',
            'cantidad_inicial' => 'integer',
            'cantidad_disponible' => 'integer',
            'precio_compra_unitario' => 'decimal:2',
        ];
    }

    /**
     * Producto al que pertenece este lote.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Verificar si el lote está vencido.
     */
    public function getVencidoAttribute(): bool
    {
        return $this->fecha_vencimiento < now();
    }

    /**
     * Verificar si el lote está por vencer (menos de 30 días).
     */
    public function getPorVencerAttribute(): bool
    {
        return $this->fecha_vencimiento <= now()->addDays(30) && !$this->vencido;
    }

    /**
     * Scope para lotes vigentes.
     */
    public function scopeVigentes($query)
    {
        return $query->where('fecha_vencimiento', '>', now())
            ->where('cantidad_disponible', '>', 0);
    }

    /**
     * Scope para lotes por vencer.
     */
    public function scopePorVencer($query)
    {
        return $query->where('fecha_vencimiento', '<=', now()->addDays(30))
            ->where('fecha_vencimiento', '>', now())
            ->where('cantidad_disponible', '>', 0);
    }
}

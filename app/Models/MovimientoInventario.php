<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'producto_id',
        'lote_id',
        'tipo_movimiento',
        'cantidad',
        'fecha_movimiento',
        'referencia_tipo',
        'referencia_id',
        'usuario_id',
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
            'fecha_movimiento' => 'datetime',
            'cantidad' => 'integer',
        ];
    }

    /**
     * Tipos de movimiento.
     */
    const TIPO_ENTRADA = 'entrada';
    const TIPO_SALIDA = 'salida';
    const TIPO_AJUSTE = 'ajuste';
    const TIPO_MERMA = 'merma';
    const TIPO_VENCIMIENTO = 'vencimiento';

    /**
     * Producto asociado al movimiento.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Lote asociado al movimiento.
     */
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    /**
     * Usuario que realizó el movimiento.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica para la referencia.
     * Puede ser una Cita, EpisodioClinico, etc.
     */
    public function referencia()
    {
        return $this->morphTo('referencia', 'referencia_tipo', 'referencia_id');
    }
}

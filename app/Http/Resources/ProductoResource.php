<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'categoria' => $this->categoria,
            'unidad_medida' => $this->unidad_medida,
            'stock_actual' => $this->stock_actual,
            'stock_minimo' => $this->stock_minimo,
            'stock_maximo' => $this->stock_maximo,
            'stock_bajo' => $this->stock_bajo,
            'precio_compra' => $this->precio_compra,
            'precio_venta' => $this->precio_venta,
            'requiere_receta' => $this->requiere_receta,
            'activo' => $this->activo,
            'lotes' => $this->whenLoaded('lotes', function () {
                return $this->lotes->map(function ($lote) {
                    return [
                        'id' => $lote->id,
                        'numero_lote' => $lote->numero_lote,
                        'fecha_vencimiento' => $lote->fecha_vencimiento->format('Y-m-d'),
                        'cantidad_disponible' => $lote->cantidad_disponible,
                        'vencido' => $lote->vencido,
                        'por_vencer' => $lote->por_vencer,
                    ];
                });
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

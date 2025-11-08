<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitaResource extends JsonResource
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
            'tipo_consulta' => $this->tipo_consulta,
            'fecha_hora' => $this->fecha_hora?->format('Y-m-d H:i:s'),
            'duracion_minutos' => $this->duracion_minutos,
            'estado' => $this->estado,
            'motivo' => $this->motivo,
            'observaciones' => $this->observaciones,
            'confirmada' => $this->confirmada,
            'recordatorio_enviado' => $this->recordatorio_enviado,
            'mascota' => [
                'id' => $this->mascota->id,
                'nombre' => $this->mascota->nombre,
                'especie' => $this->mascota->especie->nombre,
                'tutor' => [
                    'id' => $this->mascota->tutor->id,
                    'nombre_completo' => $this->mascota->tutor->nombre_completo,
                    'celular' => $this->mascota->tutor->celular,
                ],
            ],
            'veterinario' => $this->veterinario ? [
                'id' => $this->veterinario->id,
                'nombre' => $this->veterinario->name,
            ] : null,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

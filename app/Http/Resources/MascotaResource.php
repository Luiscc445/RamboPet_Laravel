<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MascotaResource extends JsonResource
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
            'nombre' => $this->nombre,
            'fecha_nacimiento' => $this->fecha_nacimiento?->format('Y-m-d'),
            'edad' => $this->edad,
            'sexo' => $this->sexo,
            'color' => $this->color,
            'peso' => $this->peso,
            'microchip' => $this->microchip,
            'esterilizado' => $this->esterilizado,
            'alergias' => $this->alergias,
            'condiciones_medicas' => $this->condiciones_medicas,
            'notas' => $this->notas,
            'activo' => $this->activo,
            'foto' => $this->foto,
            'tutor' => [
                'id' => $this->tutor->id,
                'nombre_completo' => $this->tutor->nombre_completo,
                'rut' => $this->tutor->rut,
                'celular' => $this->tutor->celular,
                'email' => $this->tutor->email,
            ],
            'especie' => [
                'id' => $this->especie->id,
                'nombre' => $this->especie->nombre,
            ],
            'raza' => $this->raza ? [
                'id' => $this->raza->id,
                'nombre' => $this->raza->nombre,
            ] : null,
            'citas' => CitaResource::collection($this->whenLoaded('citas')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

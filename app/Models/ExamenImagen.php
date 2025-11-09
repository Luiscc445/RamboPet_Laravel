<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenImagen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'examenes_imagen';

    protected $fillable = [
        'episodio_clinico_id',
        'mascota_id',
        'veterinario_id',
        'ecografista_id',
        'tipo_examen',
        'region_anatomica',
        'indicaciones',
        'estado',
        'prioridad',
        'fecha_solicitud',
        'fecha_realizacion',
        'fecha_informe',
        'archivos_imagenes',
        'hallazgos',
        'conclusion',
        'recomendaciones',
        'observaciones',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_realizacion' => 'datetime',
        'fecha_informe' => 'datetime',
        'archivos_imagenes' => 'array',
    ];

    public function episodioClinico(): BelongsTo
    {
        return $this->belongsTo(EpisodioClinico::class);
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }

    public function ecografista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ecografista_id');
    }
}

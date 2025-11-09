<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenLaboratorio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'examenes_laboratorio';

    protected $fillable = [
        'episodio_clinico_id',
        'mascota_id',
        'veterinario_id',
        'laboratorista_id',
        'tipo_examen',
        'indicaciones',
        'estado',
        'prioridad',
        'fecha_solicitud',
        'fecha_toma_muestra',
        'fecha_resultado',
        'resultados',
        'interpretacion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_toma_muestra' => 'datetime',
        'fecha_resultado' => 'datetime',
        'resultados' => 'array',
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

    public function laboratorista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'laboratorista_id');
    }
}

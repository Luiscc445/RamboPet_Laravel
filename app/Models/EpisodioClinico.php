<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EpisodioClinico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'episodios_clinicos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mascota_id',
        'cita_id',
        'veterinario_id',
        'fecha',
        'motivo_consulta',
        'anamnesis',
        'examen_fisico',
        'peso',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'diagnostico',
        'tratamiento',
        'examenes_solicitados',
        'procedimientos',
        'medicamentos',
        'proxima_visita',
        'observaciones',
        'estado',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'peso' => 'decimal:2',
            'temperatura' => 'decimal:1',
            'frecuencia_cardiaca' => 'integer',
            'frecuencia_respiratoria' => 'integer',
            'proxima_visita' => 'date',
            'examenes_solicitados' => 'array',
            'procedimientos' => 'array',
            'medicamentos' => 'array',
        ];
    }

    /**
     * Estados posibles de un episodio clínico.
     */
    const ESTADO_ABIERTO = 'abierto';
    const ESTADO_CERRADO = 'cerrado';

    /**
     * Mascota asociada al episodio clínico.
     */
    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    /**
     * Cita que originó este episodio clínico.
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Veterinario que atendió la consulta.
     */
    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }
}

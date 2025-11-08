<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'tipo_consulta',
        'fecha_hora',
        'duracion_minutos',
        'estado',
        'motivo',
        'observaciones',
        'recordatorio_enviado',
        'confirmada',
        'creado_por',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
            'duracion_minutos' => 'integer',
            'recordatorio_enviado' => 'boolean',
            'confirmada' => 'boolean',
        ];
    }

    /**
     * Estados posibles de una cita.
     */
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_CONFIRMADA = 'confirmada';
    const ESTADO_EN_CURSO = 'en_curso';
    const ESTADO_COMPLETADA = 'completada';
    const ESTADO_CANCELADA = 'cancelada';
    const ESTADO_PERDIDA = 'perdida';

    /**
     * Tipos de consulta.
     */
    const TIPO_CONSULTA_GENERAL = 'consulta_general';
    const TIPO_VACUNACION = 'vacunacion';
    const TIPO_CIRUGIA = 'cirugia';
    const TIPO_CONTROL = 'control';
    const TIPO_EMERGENCIA = 'emergencia';

    /**
     * Mascota asociada a la cita.
     */
    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    /**
     * Veterinario asignado a la cita.
     */
    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }

    /**
     * Usuario que creó la cita.
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Episodio clínico generado a partir de esta cita.
     */
    public function episodioClinico()
    {
        return $this->hasOne(EpisodioClinico::class);
    }

    /**
     * Scope para obtener citas pendientes.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    /**
     * Scope para obtener citas confirmadas.
     */
    public function scopeConfirmadas($query)
    {
        return $query->where('estado', self::ESTADO_CONFIRMADA);
    }

    /**
     * Scope para obtener citas próximas (en las siguientes 24 horas).
     */
    public function scopeProximas($query)
    {
        return $query->whereBetween('fecha_hora', [now(), now()->addDay()])
            ->whereIn('estado', [self::ESTADO_PENDIENTE, self::ESTADO_CONFIRMADA]);
    }
}

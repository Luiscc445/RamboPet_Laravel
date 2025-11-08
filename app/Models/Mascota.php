<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mascota extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'mascotas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tutor_id',
        'especie_id',
        'raza_id',
        'nombre',
        'fecha_nacimiento',
        'sexo',
        'color',
        'peso',
        'microchip',
        'esterilizado',
        'alergias',
        'condiciones_medicas',
        'notas',
        'activo',
        'foto',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'peso' => 'decimal:2',
            'esterilizado' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    /**
     * Calcular la edad de la mascota en años.
     */
    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : 0;
    }

    /**
     * Tutor (dueño) de la mascota.
     */
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Especie de la mascota.
     */
    public function especie()
    {
        return $this->belongsTo(Especie::class);
    }

    /**
     * Raza de la mascota.
     */
    public function raza()
    {
        return $this->belongsTo(Raza::class);
    }

    /**
     * Citas de esta mascota.
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /**
     * Episodios clínicos (historial médico) de esta mascota.
     */
    public function episodiosClinicos()
    {
        return $this->hasMany(EpisodioClinico::class);
    }

    /**
     * Registrar las colecciones de media (fotos).
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('fotos')
            ->singleFile();
    }
}

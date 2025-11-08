<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tutores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'celular',
        'direccion',
        'comuna',
        'region',
        'fecha_nacimiento',
        'notas',
        'activo',
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
            'activo' => 'boolean',
        ];
    }

    /**
     * Obtener el nombre completo del tutor.
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Mascotas asociadas a este tutor.
     */
    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }

    /**
     * Citas de todas las mascotas de este tutor.
     */
    public function citas()
    {
        return $this->hasManyThrough(Cita::class, Mascota::class);
    }
}

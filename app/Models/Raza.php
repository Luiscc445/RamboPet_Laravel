<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    use HasFactory;

    protected $table = 'razas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'especie_id',
        'nombre',
        'descripcion',
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
            'activo' => 'boolean',
        ];
    }

    /**
     * Especie a la que pertenece esta raza.
     */
    public function especie()
    {
        return $this->belongsTo(Especie::class);
    }

    /**
     * Mascotas de esta raza.
     */
    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}

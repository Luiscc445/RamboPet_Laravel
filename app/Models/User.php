<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'telefono',
        'rut',
        'direccion',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    /**
     * Determina si el usuario puede acceder al panel de Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (!$this->activo) {
            return false;
        }

        // Panel de administración: solo admin y recepcionistas
        if ($panel->getId() === 'admin') {
            return in_array($this->rol, ['admin', 'recepcionista']);
        }

        // Panel de veterinario: solo veterinarios
        if ($panel->getId() === 'veterinario') {
            return $this->rol === 'veterinario';
        }

        return false;
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Verifica si el usuario es veterinario.
     */
    public function isVeterinario(): bool
    {
        return $this->rol === 'veterinario';
    }

    /**
     * Verifica si el usuario es recepcionista.
     */
    public function isRecepcionista(): bool
    {
        return $this->rol === 'recepcionista';
    }

    /**
     * Citas atendidas por este usuario (si es veterinario).
     */
    public function citasAtendidas()
    {
        return $this->hasMany(Cita::class, 'veterinario_id');
    }

    /**
     * Citas creadas por este usuario (si es recepcionista).
     */
    public function citasCreadas()
    {
        return $this->hasMany(Cita::class, 'creado_por');
    }
}

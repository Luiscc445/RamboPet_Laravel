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

        // Panel de administración: solo admin
        if ($panel->getId() === 'admin') {
            return $this->rol === 'admin';
        }

        // Panel de recepción: solo recepcionistas
        if ($panel->getId() === 'recepcion') {
            return $this->rol === 'recepcionista';
        }

        // Panel de veterinario: solo veterinarios
        if ($panel->getId() === 'veterinario') {
            return $this->rol === 'veterinario';
        }

        // Panel de laboratorio: solo laboratoristas
        if ($panel->getId() === 'laboratorio') {
            return $this->rol === 'laboratorista';
        }

        // Panel de imagenología: solo ecografistas
        if ($panel->getId() === 'imagenologia') {
            return $this->rol === 'ecografista';
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
     * Verifica si el usuario es laboratorista.
     */
    public function isLaboratorista(): bool
    {
        return $this->rol === 'laboratorista';
    }

    /**
     * Verifica si el usuario es ecografista.
     */
    public function isEcografista(): bool
    {
        return $this->rol === 'ecografista';
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

    /**
     * Exámenes de laboratorio asignados a este usuario (si es laboratorista).
     */
    public function examenesLaboratorio()
    {
        return $this->hasMany(ExamenLaboratorio::class, 'laboratorista_id');
    }

    /**
     * Exámenes de imagen asignados a este usuario (si es ecografista).
     */
    public function examenesImagen()
    {
        return $this->hasMany(ExamenImagen::class, 'ecografista_id');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@rambopet.cl',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'telefono' => '+56912345678',
            'rut' => '12345678-9',
            'direccion' => 'Dirección de la Clínica',
            'activo' => true,
        ]);

        // Crear usuario veterinario
        User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'veterinario@rambopet.cl',
            'password' => Hash::make('vet123'),
            'rol' => 'veterinario',
            'telefono' => '+56987654321',
            'rut' => '98765432-1',
            'direccion' => 'Santiago, Chile',
            'activo' => true,
        ]);

        // Crear usuario recepcionista
        User::create([
            'name' => 'María González',
            'email' => 'recepcion@rambopet.cl',
            'password' => Hash::make('recep123'),
            'rol' => 'recepcionista',
            'telefono' => '+56911111111',
            'rut' => '11111111-1',
            'direccion' => 'Santiago, Chile',
            'activo' => true,
        ]);

        $this->command->info('✓ Usuarios creados correctamente');
        $this->command->info('  → Admin: admin@rambopet.cl / admin123');
        $this->command->info('  → Veterinario: veterinario@rambopet.cl / vet123');
        $this->command->info('  → Recepcionista: recepcion@rambopet.cl / recep123');
    }
}

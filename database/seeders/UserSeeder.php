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
        // Crear usuario administrador principal
        User::create([
            'name' => 'LuisCFD79',
            'email' => 'admin@rambopet.cl',
            'password' => Hash::make('Haaland900'),
            'rol' => 'admin',
            'telefono' => '+56912345678',
            'rut' => '12345678-9',
            'direccion' => 'Administración Central',
            'activo' => true,
        ]);

        // Crear usuario veterinario de prueba
        User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'veterinario@rambopet.cl',
            'password' => Hash::make('vet123'),
            'rol' => 'veterinario',
            'telefono' => '+56987654321',
            'rut' => '11223344-5',
            'direccion' => 'Santiago, Chile',
            'activo' => true,
        ]);

        $this->command->info('✓ Usuarios creados correctamente');
        $this->command->info('  → Admin: admin@rambopet.cl / Haaland900 (Usuario: LuisCFD79)');
        $this->command->info('  → Veterinario: veterinario@rambopet.cl / vet123 (Dr. Juan Pérez)');
    }
}

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

        // Crear usuario laboratorista
        User::create([
            'name' => 'María González',
            'email' => 'laboratorio@rambopet.cl',
            'password' => Hash::make('lab123'),
            'rol' => 'laboratorista',
            'telefono' => '+56998765432',
            'rut' => '22334455-6',
            'direccion' => 'Laboratorio Clínico',
            'activo' => true,
        ]);

        // Crear usuario ecografista
        User::create([
            'name' => 'Carlos Ramírez',
            'email' => 'imagenologia@rambopet.cl',
            'password' => Hash::make('eco123'),
            'rol' => 'ecografista',
            'telefono' => '+56987651234',
            'rut' => '33445566-7',
            'direccion' => 'Imagenología',
            'activo' => true,
        ]);

        $this->command->info('✓ Usuarios creados correctamente');
        $this->command->info('  → Admin: admin@rambopet.cl / Haaland900 (Usuario: LuisCFD79)');
        $this->command->info('  → Veterinario: veterinario@rambopet.cl / vet123 (Dr. Juan Pérez)');
        $this->command->info('  → Laboratorista: laboratorio@rambopet.cl / lab123 (María González)');
        $this->command->info('  → Ecografista: imagenologia@rambopet.cl / eco123 (Carlos Ramírez)');
    }
}

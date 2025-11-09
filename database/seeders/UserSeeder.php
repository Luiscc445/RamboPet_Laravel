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

        $this->command->info('✓ Usuario administrador creado correctamente');
        $this->command->info('  → Admin: admin@rambopet.cl / Haaland900');
        $this->command->info('  → Usuario: LuisCFD79');
    }
}

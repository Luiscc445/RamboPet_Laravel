#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Script de Verificación de Usuario de Prueba
|--------------------------------------------------------------------------
|
| Este script verifica si el usuario cliente@rambopet.cl existe
| y lo crea si no existe.
|
| Uso: php verificar-usuario.php
|
*/

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "\n";
echo "🔍 Verificando usuario de prueba para app móvil...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Verificar usuario cliente@rambopet.cl
$email = 'cliente@rambopet.cl';
$password = 'cliente123';

$user = User::where('email', $email)->first();

if ($user) {
    echo "✅ El usuario ya existe:\n";
    echo "   Email: {$user->email}\n";
    echo "   Nombre: {$user->name}\n";
    echo "   Rol: {$user->rol}\n";
    echo "   Activo: " . ($user->activo ? 'Sí' : 'No') . "\n\n";

    // Verificar el rol
    if ($user->rol !== 'cliente') {
        echo "⚠️  El usuario existe pero tiene rol '{$user->rol}'\n";
        echo "   Cambiando a rol 'cliente'...\n";
        $user->rol = 'cliente';
        $user->save();
        echo "✅ Rol actualizado correctamente\n\n";
    }

    // Verificar si está activo
    if (!$user->activo) {
        echo "⚠️  El usuario existe pero está inactivo\n";
        echo "   Activando usuario...\n";
        $user->activo = true;
        $user->save();
        echo "✅ Usuario activado correctamente\n\n";
    }

    // Actualizar contraseña para estar seguros
    echo "🔄 Actualizando contraseña a '$password'...\n";
    $user->password = Hash::make($password);
    $user->save();
    echo "✅ Contraseña actualizada\n\n";

} else {
    echo "❌ El usuario NO existe\n";
    echo "📝 Creando usuario...\n\n";

    $user = User::create([
        'name' => 'Pedro López',
        'email' => 'cliente@rambopet.cl',
        'password' => Hash::make($password),
        'rol' => 'cliente',
        'telefono' => '+56965432109',
        'rut' => '55667788-9',
        'direccion' => 'Santiago Centro',
        'activo' => true,
    ]);

    echo "✅ Usuario creado exitosamente:\n";
    echo "   Email: {$user->email}\n";
    echo "   Nombre: {$user->name}\n";
    echo "   Rol: {$user->rol}\n\n";
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Credenciales de prueba listas:\n";
echo "   📧 Email: cliente@rambopet.cl\n";
echo "   🔑 Password: cliente123\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Verificar que hay veterinarios
$veterinariosCount = User::where('rol', 'veterinario')->where('activo', true)->count();
echo "👨‍⚕️  Veterinarios activos en el sistema: $veterinariosCount\n";

if ($veterinariosCount === 0) {
    echo "⚠️  No hay veterinarios. Creando uno...\n";

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

    echo "✅ Veterinario creado: Dr. Juan Pérez (veterinario@rambopet.cl)\n";
}

echo "\n";
echo "🎉 Todo listo para usar la app móvil!\n\n";

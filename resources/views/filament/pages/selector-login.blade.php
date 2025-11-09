<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - RamboPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        secondary: '#3b82f6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-blue-50 min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <!-- Logo y Título -->
        <div class="flex flex-col items-center space-y-4 mb-8">
            <div class="flex items-center gap-3">
                <svg class="h-12 w-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="32" cy="42" rx="8" ry="10" fill="#10b981"/>
                    <ellipse cx="20" cy="26" rx="6" ry="7" fill="#10b981"/>
                    <ellipse cx="32" cy="22" rx="6" ry="7" fill="#10b981"/>
                    <ellipse cx="44" cy="26" rx="6" ry="7" fill="#10b981"/>
                    <ellipse cx="26" cy="32" rx="5" ry="6" fill="#10b981"/>
                    <ellipse cx="38" cy="32" rx="5" ry="6" fill="#10b981"/>
                </svg>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-900">RamboPet</span>
                    <span class="text-sm text-gray-500">Sistema Veterinario</span>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mt-4">Bienvenido</h2>
            <p class="text-gray-600">Selecciona tu tipo de acceso al sistema</p>
        </div>

        <!-- Botones de Selección -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl mb-8">
            <!-- Administrador -->
            <a href="{{ route('filament.admin.auth.login') }}"
               class="group relative flex flex-col items-center p-8 bg-white border-2 border-gray-200 rounded-2xl hover:border-emerald-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-4 bg-emerald-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Administrador</h3>
                <p class="text-sm text-gray-600 text-center">Gestión completa del sistema, inventario y configuración</p>
                <div class="mt-4 flex items-center text-emerald-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>

            <!-- Veterinario -->
            <a href="{{ route('filament.veterinario.auth.login') }}"
               class="group relative flex flex-col items-center p-8 bg-white border-2 border-gray-200 rounded-2xl hover:border-blue-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-4 bg-blue-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Veterinario</h3>
                <p class="text-sm text-gray-600 text-center">Atención de pacientes, consultas y recetas médicas</p>
                <div class="mt-4 flex items-center text-blue-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Volver al inicio -->
        <a href="/" class="text-sm text-gray-600 hover:text-emerald-600 flex items-center space-x-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver a la página principal</span>
        </a>
    </div>
</body>
</html>

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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-6xl mb-8">
            <!-- Administrador -->
            <a href="{{ route('filament.admin.auth.login') }}"
               class="group relative flex flex-col items-center p-6 bg-white border-2 border-gray-200 rounded-2xl hover:border-emerald-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-3 bg-emerald-100 rounded-full mb-3">
                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Administrador</h3>
                <p class="text-xs text-gray-600 text-center mb-3">Gestión del sistema e inventario</p>
                <div class="mt-auto flex items-center text-emerald-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>

            <!-- Veterinario -->
            <a href="{{ route('filament.veterinario.auth.login') }}"
               class="group relative flex flex-col items-center p-6 bg-white border-2 border-gray-200 rounded-2xl hover:border-blue-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-3 bg-blue-100 rounded-full mb-3">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Veterinario</h3>
                <p class="text-xs text-gray-600 text-center mb-3">Consultas y recetas médicas</p>
                <div class="mt-auto flex items-center text-blue-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>

            <!-- Laboratorista -->
            <a href="{{ route('filament.laboratorio.auth.login') }}"
               class="group relative flex flex-col items-center p-6 bg-white border-2 border-gray-200 rounded-2xl hover:border-purple-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-3 bg-purple-100 rounded-full mb-3">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Laboratorio</h3>
                <p class="text-xs text-gray-600 text-center mb-3">Exámenes y análisis clínicos</p>
                <div class="mt-auto flex items-center text-purple-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </a>

            <!-- Ecografista/Imagenología -->
            <a href="{{ route('filament.imagenologia.auth.login') }}"
               class="group relative flex flex-col items-center p-6 bg-white border-2 border-gray-200 rounded-2xl hover:border-cyan-500 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <div class="p-3 bg-cyan-100 rounded-full mb-3">
                    <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Imagenología</h3>
                <p class="text-xs text-gray-600 text-center mb-3">Ecografías y estudios de imagen</p>
                <div class="mt-auto flex items-center text-cyan-600 group-hover:translate-x-2 transition-transform">
                    <span class="text-sm font-medium">Acceder</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

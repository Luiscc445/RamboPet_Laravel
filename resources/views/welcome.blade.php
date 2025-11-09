<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RamboPet - Sistema de Gestión Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
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
    <!-- Header -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm border-b border-emerald-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <svg class="h-10 w-10" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="32" cy="42" rx="8" ry="10" fill="#10b981"/>
                        <ellipse cx="20" cy="26" rx="6" ry="7" fill="#10b981"/>
                        <ellipse cx="32" cy="22" rx="6" ry="7" fill="#10b981"/>
                        <ellipse cx="44" cy="26" rx="6" ry="7" fill="#10b981"/>
                        <ellipse cx="26" cy="32" rx="5" ry="6" fill="#10b981"/>
                        <ellipse cx="38" cy="32" rx="5" ry="6" fill="#10b981"/>
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">RamboPet</h1>
                        <p class="text-xs text-gray-500">Sistema Veterinario</p>
                    </div>
                </div>
                <div>
                    <a href="/admin" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Acceder al Sistema
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <div class="inline-flex items-center justify-center p-2 bg-emerald-100 rounded-full mb-8">
                <span class="px-4 py-1.5 text-sm font-semibold text-emerald-800">Sistema Profesional de Gestión Veterinaria</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-6">
                Cuida a tus <span class="text-emerald-600">pacientes</span><br/>
                con tecnología moderna
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-12">
                Sistema integral para la gestión de clínicas veterinarias. Administra mascotas, citas,
                historiales clínicos, inventario y mucho más desde una plataforma moderna y fácil de usar.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/admin" class="inline-flex items-center justify-center px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Comenzar Ahora
                </a>
                <a href="#features" class="inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 border-2 border-gray-200">
                    Ver Características
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-900 mb-4">Características Principales</h3>
            <p class="text-xl text-gray-600">Todo lo que necesitas para gestionar tu clínica veterinaria</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-emerald-200 transform hover:-translate-y-1">
                <div class="bg-emerald-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Gestión de Mascotas</h4>
                <p class="text-gray-600">Registra y administra información completa de cada mascota con historiales médicos detallados.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                <div class="bg-blue-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Agenda de Citas</h4>
                <p class="text-gray-600">Sistema de citas inteligente con recordatorios automáticos y gestión de horarios.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-1">
                <div class="bg-purple-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Gestión de Tutores</h4>
                <p class="text-gray-600">Administra información de clientes y propietarios con historial de interacciones.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-amber-200 transform hover:-translate-y-1">
                <div class="bg-amber-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Control de Inventario</h4>
                <p class="text-gray-600">Gestiona productos, medicamentos y suministros con alertas de stock bajo.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-red-200 transform hover:-translate-y-1">
                <div class="bg-red-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Historiales Clínicos</h4>
                <p class="text-gray-600">Episodios clínicos completos con diagnósticos, tratamientos y seguimientos.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-200 border border-gray-100 hover:border-teal-200 transform hover:-translate-y-1">
                <div class="bg-teal-100 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Reportes y Estadísticas</h4>
                <p class="text-gray-600">Dashboard con métricas en tiempo real y reportes detallados de la clínica.</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gradient-to-r from-emerald-600 to-blue-600 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <div class="text-emerald-100">Basado en la nube</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <div class="text-emerald-100">Acceso continuo</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">Seguro</div>
                    <div class="text-emerald-100">Datos protegidos</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">Moderno</div>
                    <div class="text-emerald-100">Interfaz intuitiva</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="h-8 w-8" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="32" cy="42" rx="8" ry="10" fill="#10b981"/>
                            <ellipse cx="20" cy="26" rx="6" ry="7" fill="#10b981"/>
                            <ellipse cx="32" cy="22" rx="6" ry="7" fill="#10b981"/>
                            <ellipse cx="44" cy="26" rx="6" ry="7" fill="#10b981"/>
                            <ellipse cx="26" cy="32" rx="5" ry="6" fill="#10b981"/>
                            <ellipse cx="38" cy="32" rx="5" ry="6" fill="#10b981"/>
                        </svg>
                        <span class="text-xl font-bold">RamboPet</span>
                    </div>
                    <p class="text-gray-400 text-sm">Sistema de Gestión Veterinaria © 2025</p>
                </div>
                <div>
                    <a href="/admin" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                        Acceder al Panel
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <div id="app"></div>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>

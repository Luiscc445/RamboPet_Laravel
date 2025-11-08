<template>
  <div class="py-6">
    <div class="card max-w-4xl mx-auto">
      <h1 class="text-4xl font-bold text-gray-900 mb-4">
        Bienvenido a RamboPet
      </h1>
      <p class="text-xl text-gray-600 mb-6">
        Sistema de Gestión Integral para Clínica Veterinaria Comunitaria
      </p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="card border border-primary-200">
          <h3 class="text-xl font-semibold text-primary-600 mb-2">
            Gestión de Citas
          </h3>
          <p class="text-gray-600">
            Agenda y gestiona las citas de tus mascotas de forma rápida y sencilla.
          </p>
        </div>

        <div class="card border border-primary-200">
          <h3 class="text-xl font-semibold text-primary-600 mb-2">
            Historial Clínico
          </h3>
          <p class="text-gray-600">
            Accede al historial médico completo de tus mascotas en cualquier momento.
          </p>
        </div>

        <div class="card border border-primary-200">
          <h3 class="text-xl font-semibold text-primary-600 mb-2">
            Control de Inventario
          </h3>
          <p class="text-gray-600">
            Sistema completo de gestión de medicamentos e insumos veterinarios.
          </p>
        </div>
      </div>

      <div class="mt-8 flex justify-center space-x-4">
        <router-link to="/login" class="btn-primary">
          Iniciar Sesión
        </router-link>
        <router-link to="/register" class="btn-secondary">
          Registrarse
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home',
}
</script>

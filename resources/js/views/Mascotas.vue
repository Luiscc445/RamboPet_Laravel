<template>
  <div class="py-6">
    <div class="card">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Mis Mascotas</h2>

      <div v-if="loading" class="text-center">
        <p class="text-gray-600">Cargando mascotas...</p>
      </div>

      <div v-else-if="mascotas.length === 0" class="text-center">
        <p class="text-gray-600">No tienes mascotas registradas.</p>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="mascota in mascotas"
          :key="mascota.id"
          class="border border-gray-200 rounded-lg p-4"
        >
          <h3 class="text-xl font-semibold text-gray-900 mb-2">
            {{ mascota.nombre }}
          </h3>
          <p class="text-gray-600">{{ mascota.especie.nombre }}</p>
          <p class="text-sm text-gray-500">
            {{ mascota.raza?.nombre || 'Sin raza' }}
          </p>
          <div class="mt-4 space-y-1">
            <p class="text-sm">
              <span class="font-semibold">Edad:</span> {{ mascota.edad }} años
            </p>
            <p class="text-sm">
              <span class="font-semibold">Sexo:</span> {{ mascota.sexo }}
            </p>
            <p class="text-sm" v-if="mascota.peso">
              <span class="font-semibold">Peso:</span> {{ mascota.peso }} kg
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Mascotas',
  data() {
    return {
      mascotas: [],
      loading: true,
    }
  },
  mounted() {
    this.loadMascotas();
  },
  methods: {
    async loadMascotas() {
      try {
        const response = await axios.get('/api/v1/mascotas');
        this.mascotas = response.data.data;
      } catch (error) {
        console.error('Error al cargar mascotas:', error);
      } finally {
        this.loading = false;
      }
    },
  },
}
</script>

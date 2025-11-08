<template>
  <div class="py-6">
    <div class="card">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Mis Citas</h2>

      <div v-if="loading" class="text-center">
        <p class="text-gray-600">Cargando citas...</p>
      </div>

      <div v-else-if="citas.length === 0" class="text-center">
        <p class="text-gray-600">No tienes citas programadas.</p>
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="cita in citas"
          :key="cita.id"
          class="border border-gray-200 rounded-lg p-4"
        >
          <div class="flex justify-between items-start">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">
                {{ cita.mascota.nombre }}
              </h3>
              <p class="text-gray-600">{{ cita.tipo_consulta }}</p>
              <p class="text-sm text-gray-500 mt-2">
                Fecha: {{ formatDate(cita.fecha_hora) }}
              </p>
              <p class="text-sm text-gray-500">
                Veterinario: {{ cita.veterinario?.nombre || 'Por asignar' }}
              </p>
            </div>
            <span
              class="px-3 py-1 rounded-full text-sm font-semibold"
              :class="getEstadoClass(cita.estado)"
            >
              {{ cita.estado }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Citas',
  data() {
    return {
      citas: [],
      loading: true,
    }
  },
  mounted() {
    this.loadCitas();
  },
  methods: {
    async loadCitas() {
      try {
        const response = await axios.get('/api/v1/citas');
        this.citas = response.data.data;
      } catch (error) {
        console.error('Error al cargar citas:', error);
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleString('es-CL');
    },
    getEstadoClass(estado) {
      const classes = {
        pendiente: 'bg-yellow-100 text-yellow-800',
        confirmada: 'bg-blue-100 text-blue-800',
        completada: 'bg-green-100 text-green-800',
        cancelada: 'bg-red-100 text-red-800',
      };
      return classes[estado] || 'bg-gray-100 text-gray-800';
    },
  },
}
</script>

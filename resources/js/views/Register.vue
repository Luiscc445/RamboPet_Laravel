<template>
  <div class="py-6">
    <div class="card max-w-md mx-auto">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Registro</h2>

      <form @submit.prevent="handleRegister">
        <div class="mb-4">
          <label class="label">Nombre</label>
          <input
            v-model="form.name"
            type="text"
            class="input-field"
            required
          />
        </div>

        <div class="mb-4">
          <label class="label">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="input-field"
            required
          />
        </div>

        <div class="mb-4">
          <label class="label">Teléfono</label>
          <input
            v-model="form.telefono"
            type="tel"
            class="input-field"
          />
        </div>

        <div class="mb-4">
          <label class="label">Contraseña</label>
          <input
            v-model="form.password"
            type="password"
            class="input-field"
            required
          />
        </div>

        <div class="mb-6">
          <label class="label">Confirmar Contraseña</label>
          <input
            v-model="form.password_confirmation"
            type="password"
            class="input-field"
            required
          />
        </div>

        <button type="submit" class="btn-primary w-full">
          Registrarse
        </button>
      </form>

      <p class="mt-4 text-center text-gray-600">
        ¿Ya tienes cuenta?
        <router-link to="/login" class="text-primary-600 hover:text-primary-700">
          Inicia sesión aquí
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        telefono: '',
        password: '',
        password_confirmation: '',
      },
    }
  },
  methods: {
    async handleRegister() {
      try {
        const response = await axios.post('/api/v1/register', this.form);
        localStorage.setItem('auth_token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
        this.$router.push('/citas');
      } catch (error) {
        alert('Error al registrarse: ' + (error.response?.data?.message || error.message));
      }
    },
  },
}
</script>

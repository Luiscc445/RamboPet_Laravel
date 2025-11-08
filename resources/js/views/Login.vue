<template>
  <div class="py-6">
    <div class="card max-w-md mx-auto">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Iniciar Sesión</h2>

      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="label">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="input-field"
            required
          />
        </div>

        <div class="mb-6">
          <label class="label">Contraseña</label>
          <input
            v-model="form.password"
            type="password"
            class="input-field"
            required
          />
        </div>

        <button type="submit" class="btn-primary w-full">
          Iniciar Sesión
        </button>
      </form>

      <p class="mt-4 text-center text-gray-600">
        ¿No tienes cuenta?
        <router-link to="/register" class="text-primary-600 hover:text-primary-700">
          Regístrate aquí
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    }
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post('/api/v1/login', this.form);
        localStorage.setItem('auth_token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
        this.$router.push('/citas');
      } catch (error) {
        alert('Error al iniciar sesión: ' + (error.response?.data?.message || error.message));
      }
    },
  },
}
</script>

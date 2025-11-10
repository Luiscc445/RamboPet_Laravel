import apiClient from './client';
import AsyncStorage from '@react-native-async-storage/async-storage';

export const authAPI = {
  /**
   * Iniciar sesión
   */
  login: async (email, password) => {
    const response = await apiClient.post('/login', { email, password });

    // Guardar token y usuario
    if (response.data.token) {
      await AsyncStorage.setItem('auth_token', response.data.token);
      await AsyncStorage.setItem('user', JSON.stringify(response.data.user));
    }

    return response.data;
  },

  /**
   * Registrar nuevo usuario
   */
  register: async (userData) => {
    const response = await apiClient.post('/register', userData);

    // Guardar token y usuario
    if (response.data.token) {
      await AsyncStorage.setItem('auth_token', response.data.token);
      await AsyncStorage.setItem('user', JSON.stringify(response.data.user));
    }

    return response.data;
  },

  /**
   * Cerrar sesión
   */
  logout: async () => {
    try {
      await apiClient.post('/logout');
    } catch (error) {
      console.error('Error al cerrar sesión en servidor:', error);
    } finally {
      // Limpiar storage local
      await AsyncStorage.removeItem('auth_token');
      await AsyncStorage.removeItem('user');
    }
  },

  /**
   * Obtener usuario autenticado
   */
  getMe: async () => {
    const response = await apiClient.get('/me');
    return response.data;
  },

  /**
   * Verificar si hay sesión activa
   */
  checkAuth: async () => {
    const token = await AsyncStorage.getItem('auth_token');
    const user = await AsyncStorage.getItem('user');

    if (token && user) {
      return {
        isAuthenticated: true,
        user: JSON.parse(user),
        token,
      };
    }

    return {
      isAuthenticated: false,
      user: null,
      token: null,
    };
  },
};

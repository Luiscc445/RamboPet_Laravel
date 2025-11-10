import apiClient from './client';

export const citasAPI = {
  /**
   * Obtener todas las citas del usuario
   */
  getCitas: async () => {
    const response = await apiClient.get('/citas');
    return response.data.citas || [];
  },

  /**
   * Crear nueva cita
   */
  createCita: async (citaData) => {
    const response = await apiClient.post('/citas', citaData);
    return response.data;
  },

  /**
   * Cancelar cita
   */
  cancelCita: async (citaId) => {
    const response = await apiClient.post(`/citas/${citaId}/cancel`);
    return response.data;
  },

  /**
   * Obtener veterinarios disponibles
   */
  getVeterinarios: async () => {
    const response = await apiClient.get('/veterinarios');
    return response.data.veterinarios || [];
  },
};

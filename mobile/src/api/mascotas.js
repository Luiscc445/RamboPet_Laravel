import apiClient from './client';

export const mascotasAPI = {
  /**
   * Obtener todas las mascotas del usuario
   */
  getMascotas: async () => {
    const response = await apiClient.get('/mascotas');
    return response.data.mascotas || [];
  },

  /**
   * Crear nueva mascota
   */
  createMascota: async (mascotaData) => {
    const formData = new FormData();

    // Agregar campos básicos
    formData.append('nombre', mascotaData.nombre);
    formData.append('especie_id', mascotaData.especie_id);
    formData.append('fecha_nacimiento', mascotaData.fecha_nacimiento);
    formData.append('sexo', mascotaData.sexo);

    // Campos opcionales
    if (mascotaData.raza_id) {
      formData.append('raza_id', mascotaData.raza_id);
    }
    if (mascotaData.color) {
      formData.append('color', mascotaData.color);
    }
    if (mascotaData.peso) {
      formData.append('peso', mascotaData.peso);
    }

    // Agregar foto si existe
    if (mascotaData.foto) {
      const uriParts = mascotaData.foto.split('.');
      const fileType = uriParts[uriParts.length - 1];

      formData.append('foto', {
        uri: mascotaData.foto,
        name: `mascota.${fileType}`,
        type: `image/${fileType}`,
      });
    }

    const response = await apiClient.post('/mascotas', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    return response.data;
  },

  /**
   * Obtener perfil del tutor
   */
  getTutorProfile: async () => {
    const response = await apiClient.get('/tutor/profile');
    return response.data;
  },
};

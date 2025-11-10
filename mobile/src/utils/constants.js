// CONFIGURACIÓN DE API
// Opción 1: Usar ngrok (recomendado para desarrollo y testing remoto)
// Opción 2: Usar IP local (solo funciona en la misma red WiFi)

// URL de ngrok - Cambia esta cuando inicies un nuevo túnel ngrok
export const API_BASE_URL = 'https://nonspecialized-unstatistically-eliza.ngrok-free.dev/api/mobile';

// URL local alternativa (descomenta para usar en red local)
// export const API_BASE_URL = 'http://192.168.0.72:8000/api/mobile';

// Credenciales de prueba
export const DEFAULT_CREDENTIALS = {
  email: 'cliente@rambopet.cl',
  password: 'cliente123',
};

export const TIPOS_CONSULTA = {
  consulta_general: 'Consulta General',
  vacunacion: 'Vacunación',
  cirugia: 'Cirugía',
  urgencia: 'Urgencia',
  control: 'Control',
  peluqueria: 'Peluquería',
};

export const ESTADOS_CITA = {
  pendiente: { label: 'Pendiente', color: '#f59e0b' },
  confirmada: { label: 'Confirmada', color: '#3b82f6' },
  en_atencion: { label: 'En Atención', color: '#8b5cf6' },
  completada: { label: 'Completada', color: '#10b981' },
  cancelada: { label: 'Cancelada', color: '#ef4444' },
  no_asistio: { label: 'No Asistió', color: '#6b7280' },
};

// IMPORTANTE: Cambia esta IP a la IP de tu computadora en la red local
// Para encontrar tu IP:
// Windows: ipconfig (busca IPv4)
// Mac/Linux: ifconfig (busca inet)
// Ejemplo: http://192.168.1.100:8000

export const API_BASE_URL = 'http://192.168.1.100:8000/api/mobile';

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

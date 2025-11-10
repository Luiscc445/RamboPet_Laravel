// ========================================
// CONFIGURACIÓN DE API - RamboPet
// ========================================
//
// SISTEMA DE DOBLE TÚNEL NGROK:
// 1. Túnel Backend  (Laravel API)    - Puerto 8000
// 2. Túnel Frontend (React Native)   - Puerto 8081
//
// Para iniciar ambos túneles:
//   Windows: start-ngrok-dual.bat
//   Linux/Mac: ./start-ngrok-dual.sh
//
// O iniciar todo automáticamente:
//   Windows: start-all.bat
//
// ========================================

// URL del Backend Laravel (API REST)
// Cámbiala por la URL del túnel "backend" que aparece en ngrok
export const API_BASE_URL = 'https://nonspecialized-unstatistically-eliza.ngrok-free.dev/api/mobile';

// ALTERNATIVAS:
// Opción 1: IP local (solo funciona en la misma red WiFi)
// export const API_BASE_URL = 'http://192.168.0.72:8000/api/mobile';

// Opción 2: Localhost (solo para desarrollo en el mismo equipo)
// export const API_BASE_URL = 'http://localhost:8000/api/mobile';

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

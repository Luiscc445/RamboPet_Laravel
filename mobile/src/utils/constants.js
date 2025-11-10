// ========================================
// CONFIGURACIÓN DE API - RamboPet
// ========================================
//
// Backend Laravel corre en puerto 8000
// App móvil se expone en puerto 8081 usando localtunnel
//
// Para iniciar:
//   1. Backend: php artisan serve --port=8000
//   2. App móvil: npm start (en carpeta mobile)
//   3. Túnel web: npm run tunnel (en carpeta mobile)
//
// ========================================

// URL del Backend Laravel (API REST)
// Opción 1: Localhost (desarrollo en el mismo equipo) - RECOMENDADO para desarrollo local
export const API_BASE_URL = 'http://localhost:8000/api/mobile';

// Opción 2: IP local (desde otro dispositivo en la misma red WiFi)
// Cambia la IP por la de tu computadora (ejecuta: ipconfig en Windows o ifconfig en Linux/Mac)
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

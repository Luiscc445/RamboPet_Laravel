# API Mobile - RamboPet

Documentación completa de la API REST para la aplicación móvil de RamboPet.

**Base URL:** `/api/mobile`

**Autenticación:** Laravel Sanctum (Bearer Token)

---

## 📋 Índice

1. [Autenticación](#autenticación)
2. [Perfil del Tutor](#perfil-del-tutor)
3. [Catálogos](#catálogos)
4. [Mascotas](#mascotas)
5. [Veterinarios](#veterinarios)
6. [Citas](#citas)
7. [Flujo de Usuario](#flujo-de-usuario)

---

## 🔐 Autenticación

### Registro de Nuevo Tutor

Permite registrar un nuevo usuario (tutor/dueño de mascota) en el sistema.

**Endpoint:** `POST /api/mobile/register`

**Tipo:** Público (no requiere token)

**Body:**
```json
{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "telefono": "+56912345678",
  "rut": "12345678-9",
  "direccion": "Av. Providencia 123, Santiago"
}
```

**Respuesta Exitosa (201):**
```json
{
  "message": "Usuario registrado exitosamente",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "telefono": "+56912345678",
    "rut": "12345678-9",
    "direccion": "Av. Providencia 123, Santiago",
    "rol": "cliente",
    "activo": true
  },
  "token": "1|AbCdEfGhIjKlMnOpQrStUvWxYz..."
}
```

---

### Iniciar Sesión

**Endpoint:** `POST /api/mobile/login`

**Tipo:** Público

**Body:**
```json
{
  "email": "juan@example.com",
  "password": "password123"
}
```

**Respuesta Exitosa (200):**
```json
{
  "message": "Inicio de sesión exitoso",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "rol": "cliente"
  },
  "token": "2|AbCdEfGhIjKlMnOpQrStUvWxYz..."
}
```

---

### Cerrar Sesión

**Endpoint:** `POST /api/mobile/logout`

**Tipo:** Protegido (requiere token)

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
  "message": "Sesión cerrada exitosamente"
}
```

---

### Obtener Usuario Autenticado

**Endpoint:** `GET /api/mobile/me`

**Tipo:** Protegido

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
  "id": 1,
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "telefono": "+56912345678",
  "rut": "12345678-9",
  "direccion": "Av. Providencia 123, Santiago",
  "rol": "cliente",
  "activo": true
}
```

---

## 👤 Perfil del Tutor

### Obtener Perfil

Obtiene el perfil completo del tutor. Si no existe, lo crea automáticamente.

**Endpoint:** `GET /api/mobile/tutor/profile`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "id": 1,
  "rut": "12345678-9",
  "nombre": "Juan",
  "apellido": "Pérez",
  "email": "juan@example.com",
  "telefono": "+56912345678",
  "celular": "+56987654321",
  "direccion": "Av. Providencia 123",
  "comuna": "Providencia",
  "region": "Metropolitana",
  "fecha_nacimiento": null,
  "notas": null,
  "activo": true,
  "created_at": "2024-11-10T10:00:00.000000Z",
  "updated_at": "2024-11-10T10:00:00.000000Z"
}
```

---

### Actualizar Perfil

**Endpoint:** `PUT /api/mobile/tutor/profile`

**Tipo:** Protegido

**Body (todos los campos son opcionales):**
```json
{
  "nombre": "Juan",
  "apellido": "Pérez González",
  "telefono": "+56912345678",
  "celular": "+56987654321",
  "direccion": "Av. Providencia 456",
  "comuna": "Providencia",
  "region": "Metropolitana"
}
```

**Respuesta Exitosa (200):**
```json
{
  "message": "Perfil actualizado exitosamente",
  "tutor": {
    "id": 1,
    "nombre": "Juan",
    "apellido": "Pérez González",
    ...
  }
}
```

---

## 📚 Catálogos

### Listar Especies

Obtiene todas las especies de animales disponibles (necesario para registrar mascotas).

**Endpoint:** `GET /api/mobile/especies`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "especies": [
    {
      "id": 1,
      "nombre": "Perro",
      "descripcion": "Canis lupus familiaris",
      "activo": true
    },
    {
      "id": 2,
      "nombre": "Gato",
      "descripcion": "Felis catus",
      "activo": true
    }
  ]
}
```

---

### Listar Razas

Obtiene todas las razas disponibles. Se puede filtrar por especie.

**Endpoint:** `GET /api/mobile/razas`

**Tipo:** Protegido

**Query Parameters:**
- `especie_id` (opcional): ID de la especie para filtrar

**Ejemplos:**
- `/api/mobile/razas` - Todas las razas
- `/api/mobile/razas?especie_id=1` - Solo razas de perros

**Respuesta Exitosa (200):**
```json
{
  "razas": [
    {
      "id": 1,
      "especie_id": 1,
      "nombre": "Labrador",
      "descripcion": "Perro de tamaño grande",
      "activo": true,
      "especie": {
        "id": 1,
        "nombre": "Perro"
      }
    },
    {
      "id": 2,
      "especie_id": 1,
      "nombre": "Golden Retriever",
      "descripcion": "Perro de tamaño grande",
      "activo": true,
      "especie": {
        "id": 1,
        "nombre": "Perro"
      }
    }
  ]
}
```

---

## 🐾 Mascotas

### Listar Mascotas del Tutor

**Endpoint:** `GET /api/mobile/mascotas`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "mascotas": [
    {
      "id": 1,
      "tutor_id": 1,
      "especie_id": 1,
      "raza_id": 1,
      "nombre": "Max",
      "fecha_nacimiento": "2020-05-15",
      "sexo": "macho",
      "color": "Dorado",
      "peso": 25.5,
      "microchip": null,
      "esterilizado": false,
      "alergias": null,
      "condiciones_medicas": null,
      "notas": null,
      "foto": "mascotas/abc123.jpg",
      "activo": true,
      "especie": {
        "id": 1,
        "nombre": "Perro"
      },
      "raza": {
        "id": 1,
        "nombre": "Labrador"
      }
    }
  ]
}
```

---

### Registrar Nueva Mascota

**Endpoint:** `POST /api/mobile/mascotas`

**Tipo:** Protegido

**Content-Type:** `multipart/form-data` (si incluye foto) o `application/json`

**Body:**
```json
{
  "nombre": "Max",
  "especie_id": 1,
  "raza_id": 1,
  "fecha_nacimiento": "2020-05-15",
  "sexo": "macho",
  "color": "Dorado",
  "peso": 25.5,
  "foto": "(archivo de imagen, max 2MB)"
}
```

**Campos Requeridos:**
- `nombre`: string
- `especie_id`: integer (debe existir)
- `fecha_nacimiento`: date (YYYY-MM-DD)
- `sexo`: enum (macho, hembra)

**Campos Opcionales:**
- `raza_id`: integer
- `color`: string
- `peso`: numeric
- `foto`: image (max 2MB)

**Respuesta Exitosa (201):**
```json
{
  "message": "Mascota registrada exitosamente",
  "mascota": {
    "id": 1,
    "nombre": "Max",
    ...
  }
}
```

---

### Actualizar Mascota

**Endpoint:** `PUT /api/mobile/mascotas/{id}`

**Tipo:** Protegido

**Body (todos los campos son opcionales):**
```json
{
  "nombre": "Max Jr.",
  "peso": 26.0,
  "color": "Dorado claro",
  "alergias": "Polen",
  "condiciones_medicas": "Ninguna",
  "esterilizado": true
}
```

**Respuesta Exitosa (200):**
```json
{
  "message": "Mascota actualizada exitosamente",
  "mascota": {
    "id": 1,
    "nombre": "Max Jr.",
    ...
  }
}
```

---

### Eliminar Mascota

**Endpoint:** `DELETE /api/mobile/mascotas/{id}`

**Tipo:** Protegido

**Nota:** No se puede eliminar si tiene citas pendientes o confirmadas.

**Respuesta Exitosa (200):**
```json
{
  "message": "Mascota eliminada exitosamente"
}
```

**Error (400) - Tiene citas pendientes:**
```json
{
  "message": "No se puede eliminar la mascota porque tiene citas pendientes o confirmadas"
}
```

---

## 👨‍⚕️ Veterinarios

### Listar Veterinarios Disponibles

**Endpoint:** `GET /api/mobile/veterinarios`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "veterinarios": [
    {
      "id": 5,
      "name": "Dr. Carlos Méndez",
      "email": "carlos@rambopet.cl",
      "telefono": "+56922334455"
    },
    {
      "id": 6,
      "name": "Dra. María Silva",
      "email": "maria@rambopet.cl",
      "telefono": "+56933445566"
    }
  ]
}
```

---

## 📅 Citas

### Listar Citas del Tutor

Obtiene todas las citas de todas las mascotas del tutor.

**Endpoint:** `GET /api/mobile/citas`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "citas": [
    {
      "id": 1,
      "mascota_id": 1,
      "veterinario_id": 5,
      "tipo_consulta": "consulta_general",
      "fecha_hora": "2024-11-15 10:00:00",
      "duracion_minutos": 30,
      "estado": "pendiente",
      "motivo": "Control de rutina",
      "observaciones": null,
      "confirmada": false,
      "mascota": {
        "id": 1,
        "nombre": "Max",
        "especie": {
          "nombre": "Perro"
        }
      },
      "veterinario": {
        "id": 5,
        "name": "Dr. Carlos Méndez"
      }
    }
  ]
}
```

---

### Ver Detalle de Cita

**Endpoint:** `GET /api/mobile/citas/{id}`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "cita": {
    "id": 1,
    "mascota_id": 1,
    "veterinario_id": 5,
    "tipo_consulta": "consulta_general",
    "fecha_hora": "2024-11-15 10:00:00",
    "duracion_minutos": 30,
    "estado": "pendiente",
    "motivo": "Control de rutina",
    "observaciones": null,
    "confirmada": false,
    "mascota": {
      "id": 1,
      "nombre": "Max",
      "especie": {
        "id": 1,
        "nombre": "Perro"
      },
      "raza": {
        "id": 1,
        "nombre": "Labrador"
      }
    },
    "veterinario": {
      "id": 5,
      "name": "Dr. Carlos Méndez",
      "email": "carlos@rambopet.cl"
    }
  }
}
```

---

### Crear Nueva Cita

**Endpoint:** `POST /api/mobile/citas`

**Tipo:** Protegido

**Body:**
```json
{
  "mascota_id": 1,
  "veterinario_id": 5,
  "fecha_hora": "2024-11-15 10:00:00",
  "tipo_consulta": "consulta_general",
  "motivo": "Control de rutina"
}
```

**Campos Requeridos:**
- `mascota_id`: integer (debe pertenecer al tutor)
- `veterinario_id`: integer (debe ser un usuario con rol veterinario)
- `fecha_hora`: datetime (debe ser futura)
- `tipo_consulta`: enum

**Tipos de Consulta Válidos:**
- `consulta_general`
- `vacunacion`
- `cirugia`
- `urgencia`
- `emergencia`
- `control`
- `peluqueria`

**Campos Opcionales:**
- `motivo`: string

**Respuesta Exitosa (201):**
```json
{
  "message": "Cita agendada exitosamente",
  "cita": {
    "id": 1,
    "mascota_id": 1,
    "veterinario_id": 5,
    "tipo_consulta": "consulta_general",
    "fecha_hora": "2024-11-15 10:00:00",
    "estado": "pendiente",
    "confirmada": false,
    ...
  }
}
```

---

### Cancelar Cita

**Endpoint:** `POST /api/mobile/citas/{id}/cancel`

**Tipo:** Protegido

**Respuesta Exitosa (200):**
```json
{
  "message": "Cita cancelada exitosamente",
  "cita": {
    "id": 1,
    "estado": "cancelada",
    ...
  }
}
```

---

## 🔄 Flujo de Usuario

### 1. Registro e Inicio de Sesión

```
1. Usuario descarga la app
2. POST /api/mobile/register
   - Ingresa: nombre, email, password, teléfono, RUT, dirección
   - Recibe: user + token
3. Guardar token en almacenamiento local/seguro
4. Incluir token en todas las peticiones futuras:
   Header: Authorization: Bearer {token}
```

### 2. Configuración Inicial del Perfil

```
5. GET /api/mobile/tutor/profile
   - El sistema crea automáticamente el perfil si no existe
6. PUT /api/mobile/tutor/profile (opcional)
   - Completar información adicional: apellido, celular, comuna, región
```

### 3. Registro de Primera Mascota

```
7. GET /api/mobile/especies
   - Mostrar selector de especies
8. GET /api/mobile/razas?especie_id={id}
   - Al seleccionar especie, cargar razas correspondientes
9. POST /api/mobile/mascotas
   - Enviar datos de la mascota + foto
   - Recibe mascota registrada
```

### 4. Agendar Primera Cita

```
10. GET /api/mobile/mascotas
    - Listar mascotas del tutor para selección
11. GET /api/mobile/veterinarios
    - Mostrar veterinarios disponibles
12. POST /api/mobile/citas
    - mascota_id, veterinario_id, fecha_hora, tipo_consulta, motivo
    - Recibe confirmación de cita agendada
```

### 5. Gestión Continua

```
13. GET /api/mobile/citas
    - Ver todas las citas (pasadas, presentes, futuras)
14. GET /api/mobile/citas/{id}
    - Ver detalle de una cita específica
15. POST /api/mobile/citas/{id}/cancel
    - Cancelar cita si es necesario
16. PUT /api/mobile/mascotas/{id}
    - Actualizar información de mascota (peso, alergias, etc.)
```

---

## 🔒 Seguridad

### Autenticación
- Todas las rutas protegidas requieren header: `Authorization: Bearer {token}`
- El token se obtiene en login o register
- El token debe almacenarse de forma segura en el dispositivo

### Autorización
- Solo rol 'cliente' puede acceder a endpoints mobile
- Los tutores solo pueden ver/modificar sus propias mascotas
- Los tutores solo pueden ver/modificar citas de sus mascotas
- Validación de propiedad en todas las operaciones

### Validaciones
- Todos los inputs son validados en el servidor
- Las imágenes están limitadas a 2MB
- Las fechas de citas deben ser futuras
- No se pueden eliminar mascotas con citas pendientes

---

## ❌ Manejo de Errores

### Códigos de Estado HTTP

- `200 OK` - Operación exitosa
- `201 Created` - Recurso creado exitosamente
- `400 Bad Request` - Error de validación
- `401 Unauthorized` - Token inválido o ausente
- `403 Forbidden` - No autorizado para esta acción
- `404 Not Found` - Recurso no encontrado
- `422 Unprocessable Entity` - Error de validación detallado
- `500 Internal Server Error` - Error del servidor

### Formato de Respuestas de Error

**Validación (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "El campo email es obligatorio."
    ],
    "password": [
      "El campo password debe tener al menos 8 caracteres."
    ]
  }
}
```

**No autorizado (401):**
```json
{
  "message": "Unauthenticated."
}
```

**Prohibido (403):**
```json
{
  "message": "No autorizado"
}
```

---

## 📱 Ejemplo de Integración

### React Native / Expo

```javascript
const API_BASE_URL = 'https://tu-servidor.com/api/mobile';

// Registro
const register = async (userData) => {
  const response = await fetch(`${API_BASE_URL}/register`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(userData),
  });
  const data = await response.json();

  if (response.ok) {
    // Guardar token
    await AsyncStorage.setItem('token', data.token);
    return data;
  }
  throw new Error(data.message);
};

// Login
const login = async (email, password) => {
  const response = await fetch(`${API_BASE_URL}/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password }),
  });
  const data = await response.json();

  if (response.ok) {
    await AsyncStorage.setItem('token', data.token);
    return data;
  }
  throw new Error(data.message);
};

// Obtener mascotas (autenticado)
const getMascotas = async () => {
  const token = await AsyncStorage.getItem('token');

  const response = await fetch(`${API_BASE_URL}/mascotas`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    },
  });

  const data = await response.json();

  if (response.ok) {
    return data.mascotas;
  }
  throw new Error(data.message);
};

// Crear cita
const crearCita = async (citaData) => {
  const token = await AsyncStorage.getItem('token');

  const response = await fetch(`${API_BASE_URL}/citas`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify(citaData),
  });

  const data = await response.json();

  if (response.ok) {
    return data.cita;
  }
  throw new Error(data.message);
};
```

---

## 🚀 Próximas Funcionalidades

Funcionalidades planificadas para futuras versiones:

- [ ] Notificaciones push para recordatorios de citas
- [ ] Cambio de contraseña
- [ ] Recuperación de contraseña
- [ ] Historial médico de mascotas
- [ ] Descarga de documentos (recetas, exámenes)
- [ ] Chat con veterinario
- [ ] Paginación en listados
- [ ] Filtros avanzados en citas
- [ ] Valoración de servicios
- [ ] Tienda de productos

---

## 📞 Soporte

Para reportar problemas o solicitar funcionalidades, contactar al equipo de desarrollo.

**Versión:** 1.0.0
**Última actualización:** 2024-11-10

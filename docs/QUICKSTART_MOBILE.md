# 🚀 Quick Start - App Móvil RamboPet

Guía rápida para conectar tu aplicación móvil al backend de RamboPet.

## 📋 Requisitos Previos

1. Servidor Laravel ejecutándose
2. Base de datos configurada y migrada
3. Datos de especies y razas cargados (seeders)

## ⚙️ Configuración del Backend

### 1. Ejecutar Migraciones

```bash
php artisan migrate
```

### 2. Cargar Datos Iniciales (Seeders)

```bash
php artisan db:seed --class=EspeciesSeeder
php artisan db:seed --class=RazasSeeder
```

### 3. Crear Usuario Veterinario de Prueba

```bash
php artisan tinker
```

Luego ejecutar:
```php
\App\Models\User::create([
    'name' => 'Dr. Carlos Méndez',
    'email' => 'veterinario@rambopet.cl',
    'password' => bcrypt('password123'),
    'rol' => 'veterinario',
    'telefono' => '+56922334455',
    'activo' => true
]);
```

## 📱 Integración con la App Móvil

### URL Base de la API

```
http://tu-servidor.com/api/mobile
```

**Importante:** Todas las rutas protegidas requieren el header:
```
Authorization: Bearer {token}
```

## 🔑 Flujo Básico de Autenticación

### 1. Registro de Nuevo Tutor

**Endpoint:** `POST /api/mobile/register`

```javascript
const registerUser = async () => {
  const response = await fetch('http://tu-servidor.com/api/mobile/register', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify({
      name: 'Juan Pérez',
      email: 'juan@example.com',
      password: 'password123',
      password_confirmation: 'password123',
      telefono: '+56912345678',
      rut: '12345678-9',
      direccion: 'Av. Providencia 123'
    })
  });

  const data = await response.json();

  if (response.ok) {
    // Guardar token para futuras peticiones
    const token = data.token;
    // AsyncStorage.setItem('token', token); // React Native
    // localStorage.setItem('token', token); // Web
    console.log('Usuario registrado:', data.user);
    return { user: data.user, token: data.token };
  } else {
    console.error('Error:', data.message);
    throw new Error(data.message);
  }
};
```

### 2. Iniciar Sesión

**Endpoint:** `POST /api/mobile/login`

```javascript
const login = async (email, password) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify({ email, password })
  });

  const data = await response.json();

  if (response.ok) {
    return { user: data.user, token: data.token };
  } else {
    throw new Error(data.message);
  }
};
```

## 🐾 Gestión de Mascotas

### 1. Obtener Especies y Razas

```javascript
const getEspecies = async (token) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/especies', {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.especies;
};

const getRazas = async (token, especieId) => {
  const url = especieId
    ? `http://tu-servidor.com/api/mobile/razas?especie_id=${especieId}`
    : 'http://tu-servidor.com/api/mobile/razas';

  const response = await fetch(url, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.razas;
};
```

### 2. Registrar Mascota

```javascript
const registrarMascota = async (token, mascotaData) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/mascotas', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify({
      nombre: mascotaData.nombre,
      especie_id: mascotaData.especieId,
      raza_id: mascotaData.razaId,
      fecha_nacimiento: mascotaData.fechaNacimiento, // "2020-05-15"
      sexo: mascotaData.sexo, // "macho" o "hembra"
      color: mascotaData.color,
      peso: mascotaData.peso
    })
  });

  const data = await response.json();

  if (response.ok) {
    return data.mascota;
  } else {
    throw new Error(data.message);
  }
};
```

### 3. Registrar Mascota con Foto

```javascript
// React Native / Expo
const registrarMascotaConFoto = async (token, mascotaData, imageUri) => {
  const formData = new FormData();

  formData.append('nombre', mascotaData.nombre);
  formData.append('especie_id', mascotaData.especieId);
  formData.append('raza_id', mascotaData.razaId);
  formData.append('fecha_nacimiento', mascotaData.fechaNacimiento);
  formData.append('sexo', mascotaData.sexo);
  formData.append('color', mascotaData.color);
  formData.append('peso', mascotaData.peso);

  // Agregar foto
  if (imageUri) {
    const filename = imageUri.split('/').pop();
    const match = /\.(\w+)$/.exec(filename);
    const type = match ? `image/${match[1]}` : 'image/jpeg';

    formData.append('foto', {
      uri: imageUri,
      name: filename,
      type: type
    });
  }

  const response = await fetch('http://tu-servidor.com/api/mobile/mascotas', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
      'Content-Type': 'multipart/form-data',
    },
    body: formData
  });

  const data = await response.json();

  if (response.ok) {
    return data.mascota;
  } else {
    throw new Error(data.message);
  }
};
```

### 4. Listar Mascotas del Tutor

```javascript
const getMascotas = async (token) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/mascotas', {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.mascotas;
};
```

## 📅 Gestión de Citas

### 1. Obtener Veterinarios Disponibles

```javascript
const getVeterinarios = async (token) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/veterinarios', {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.veterinarios;
};
```

### 2. Crear Cita

```javascript
const crearCita = async (token, citaData) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/citas', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify({
      mascota_id: citaData.mascotaId,
      veterinario_id: citaData.veterinarioId,
      fecha_hora: citaData.fechaHora, // "2024-11-15 10:00:00"
      tipo_consulta: citaData.tipoConsulta, // "consulta_general", "vacunacion", etc.
      motivo: citaData.motivo
    })
  });

  const data = await response.json();

  if (response.ok) {
    return data.cita;
  } else {
    throw new Error(data.message);
  }
};
```

**Tipos de Consulta Válidos:**
- `consulta_general`
- `vacunacion`
- `cirugia`
- `urgencia`
- `emergencia`
- `control`
- `peluqueria`

### 3. Listar Citas

```javascript
const getCitas = async (token) => {
  const response = await fetch('http://tu-servidor.com/api/mobile/citas', {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.citas;
};
```

### 4. Ver Detalle de Cita

```javascript
const getDetalleCita = async (token, citaId) => {
  const response = await fetch(`http://tu-servidor.com/api/mobile/citas/${citaId}`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();
  return data.cita;
};
```

### 5. Cancelar Cita

```javascript
const cancelarCita = async (token, citaId) => {
  const response = await fetch(`http://tu-servidor.com/api/mobile/citas/${citaId}/cancel`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    }
  });

  const data = await response.json();

  if (response.ok) {
    return data.cita;
  } else {
    throw new Error(data.message);
  }
};
```

## 🔄 Flujo Completo de Usuario Nuevo

```javascript
async function flujoCompletoUsuarioNuevo() {
  try {
    // 1. Registrar usuario
    const { user, token } = await registerUser();
    console.log('Usuario registrado:', user.name);

    // 2. Obtener especies
    const especies = await getEspecies(token);
    console.log('Especies disponibles:', especies.length);

    // 3. Seleccionar especie (ejemplo: Perro = ID 1)
    const especieId = 1;
    const razas = await getRazas(token, especieId);
    console.log('Razas disponibles:', razas.length);

    // 4. Registrar mascota
    const mascota = await registrarMascota(token, {
      nombre: 'Max',
      especieId: 1,
      razaId: razas[0].id,
      fechaNacimiento: '2020-05-15',
      sexo: 'macho',
      color: 'Dorado',
      peso: 25.5
    });
    console.log('Mascota registrada:', mascota.nombre);

    // 5. Obtener veterinarios
    const veterinarios = await getVeterinarios(token);
    console.log('Veterinarios disponibles:', veterinarios.length);

    // 6. Crear cita
    const cita = await crearCita(token, {
      mascotaId: mascota.id,
      veterinarioId: veterinarios[0].id,
      fechaHora: '2024-11-15 10:00:00',
      tipoConsulta: 'consulta_general',
      motivo: 'Control de rutina'
    });
    console.log('Cita creada:', cita.id);

    // 7. Ver todas las citas
    const citas = await getCitas(token);
    console.log('Total de citas:', citas.length);

    console.log('✅ Flujo completo exitoso!');
  } catch (error) {
    console.error('❌ Error:', error.message);
  }
}
```

## 🛠️ Helpers para React Native

### API Service (api.js)

```javascript
import AsyncStorage from '@react-native-async-storage/async-storage';

const API_BASE_URL = 'http://tu-servidor.com/api/mobile';

// Helper para hacer peticiones autenticadas
const authFetch = async (endpoint, options = {}) => {
  const token = await AsyncStorage.getItem('token');

  const headers = {
    'Accept': 'application/json',
    ...options.headers,
  };

  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  if (options.body && !(options.body instanceof FormData)) {
    headers['Content-Type'] = 'application/json';
    options.body = JSON.stringify(options.body);
  }

  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    ...options,
    headers,
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error(data.message || 'Error en la petición');
  }

  return data;
};

// Exportar funciones de la API
export const api = {
  // Auth
  register: (userData) => authFetch('/register', {
    method: 'POST',
    body: userData,
  }),

  login: async (email, password) => {
    const data = await authFetch('/login', {
      method: 'POST',
      body: { email, password },
    });
    await AsyncStorage.setItem('token', data.token);
    return data;
  },

  logout: async () => {
    await authFetch('/logout', { method: 'POST' });
    await AsyncStorage.removeItem('token');
  },

  // Mascotas
  getMascotas: () => authFetch('/mascotas'),
  crearMascota: (mascotaData) => authFetch('/mascotas', {
    method: 'POST',
    body: mascotaData,
  }),
  actualizarMascota: (id, mascotaData) => authFetch(`/mascotas/${id}`, {
    method: 'PUT',
    body: mascotaData,
  }),
  eliminarMascota: (id) => authFetch(`/mascotas/${id}`, {
    method: 'DELETE',
  }),

  // Citas
  getCitas: () => authFetch('/citas'),
  getDetalleCita: (id) => authFetch(`/citas/${id}`),
  crearCita: (citaData) => authFetch('/citas', {
    method: 'POST',
    body: citaData,
  }),
  cancelarCita: (id) => authFetch(`/citas/${id}/cancel`, {
    method: 'POST',
  }),

  // Catálogos
  getEspecies: () => authFetch('/especies'),
  getRazas: (especieId) => authFetch(especieId ? `/razas?especie_id=${especieId}` : '/razas'),
  getVeterinarios: () => authFetch('/veterinarios'),

  // Perfil
  getPerfil: () => authFetch('/tutor/profile'),
  actualizarPerfil: (perfilData) => authFetch('/tutor/profile', {
    method: 'PUT',
    body: perfilData,
  }),
};
```

### Uso en componentes

```javascript
import { api } from './services/api';

// En tu componente
const LoginScreen = () => {
  const handleLogin = async () => {
    try {
      const { user, token } = await api.login(email, password);
      // Navegar a pantalla principal
      navigation.navigate('Home');
    } catch (error) {
      Alert.alert('Error', error.message);
    }
  };

  return (
    // Tu UI aquí
  );
};
```

## 🧪 Pruebas con cURL

### Registro
```bash
curl -X POST http://tu-servidor.com/api/mobile/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "telefono": "+56912345678",
    "rut": "12345678-9",
    "direccion": "Av. Providencia 123"
  }'
```

### Login
```bash
curl -X POST http://tu-servidor.com/api/mobile/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "juan@example.com",
    "password": "password123"
  }'
```

### Listar Mascotas (autenticado)
```bash
curl -X GET http://tu-servidor.com/api/mobile/mascotas \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

## 📚 Documentación Completa

Para ver la documentación completa de todos los endpoints, consulta:
- [API_MOBILE.md](./API_MOBILE.md)

## ❓ Preguntas Frecuentes

**P: ¿Cómo manejo errores de validación?**

R: Los errores de validación vienen en formato 422 con detalles:
```javascript
if (response.status === 422) {
  const errors = data.errors;
  // errors.email => ["El campo email es obligatorio"]
}
```

**P: ¿Cuánto tiempo dura el token?**

R: Los tokens de Sanctum no expiran por defecto. Puedes configurar la expiración en `config/sanctum.php`.

**P: ¿Cómo subo imágenes?**

R: Usa `FormData` con `Content-Type: multipart/form-data`. Ver ejemplo en "Registrar Mascota con Foto".

**P: ¿Puedo usar la API desde un navegador web?**

R: Sí, la API funciona igual desde cualquier cliente HTTP (web, móvil, desktop).

---

**¡Listo para empezar!** 🎉

Si tienes problemas, revisa los logs del servidor Laravel con:
```bash
tail -f storage/logs/laravel.log
```

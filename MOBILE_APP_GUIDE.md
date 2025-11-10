# 📱 RamboPet - Guía de App Móvil React Native

## 🎯 Descripción General

App móvil para tutores/clientes de RamboPet que permite:
- ✅ Registro e inicio de sesión
- ✅ Gestión de mascotas (crear, ver, subir fotos)
- ✅ Agendar citas con veterinarios
- ✅ Ver historial de citas
- ✅ Cancelar citas

---

## 🚀 Instalación y Configuración

### 1. Instalar Expo CLI (si no lo tienes)

```bash
npm install -g expo-cli
```

### 2. Crear proyecto React Native con Expo

```bash
npx create-expo-app RamboPetMobile
cd RamboPetMobile
```

### 3. Instalar dependencias necesarias

```bash
# Navegación
npm install @react-navigation/native @react-navigation/bottom-tabs @react-navigation/stack
npm install react-native-screens react-native-safe-area-context

# Formularios y validación
npm install react-hook-form yup @hookform/resolvers

# HTTP Client
npm install axios

# Manejo de estado
npm install zustand

# Imagenes y permisos
npm install expo-image-picker
npm install expo-document-picker

# Almacenamiento local
npm install @react-native-async-storage/async-storage

# Fecha y hora
npm install date-fns

# UI Components (opcional)
npm install react-native-paper
```

---

## 📁 Estructura del Proyecto

```
RamboPetMobile/
├── src/
│   ├── api/
│   │   ├── client.js         # Configuración de Axios
│   │   ├── auth.js           # Endpoints de autenticación
│   │   ├── mascotas.js       # Endpoints de mascotas
│   │   └── citas.js          # Endpoints de citas
│   ├── components/
│   │   ├── MascotaCard.jsx   # Tarjeta de mascota
│   │   ├── CitaCard.jsx      # Tarjeta de cita
│   │   └── LoadingSpinner.jsx
│   ├── screens/
│   │   ├── Auth/
│   │   │   ├── LoginScreen.jsx
│   │   │   └── RegisterScreen.jsx
│   │   ├── Home/
│   │   │   └── HomeScreen.jsx
│   │   ├── Mascotas/
│   │   │   ├── MascotasListScreen.jsx
│   │   │   └── AddMascotaScreen.jsx
│   │   ├── Citas/
│   │   │   ├── CitasListScreen.jsx
│   │   │   └── AgendarCitaScreen.jsx
│   │   └── Profile/
│   │       └── ProfileScreen.jsx
│   ├── store/
│   │   └── authStore.js      # Store de autenticación con Zustand
│   ├── navigation/
│   │   └── AppNavigator.jsx  # Navegación principal
│   └── utils/
│       ├── storage.js        # Helpers para AsyncStorage
│       └── constants.js      # Constantes y configuración
├── App.js
└── package.json
```

---

## 🔧 Configuración del API Client

### `src/api/client.js`

```javascript
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

// CAMBIA ESTA URL A TU BACKEND LARAVEL
const API_URL = 'http://tu-ip:8000/api/mobile';

const apiClient = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Interceptor para agregar token en cada request
apiClient.interceptors.request.use(
  async (config) => {
    const token = await AsyncStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default apiClient;
```

### `src/api/auth.js`

```javascript
import apiClient from './client';

export const authAPI = {
  login: async (email, password) => {
    const response = await apiClient.post('/login', { email, password });
    return response.data;
  },

  register: async (userData) => {
    const response = await apiClient.post('/register', userData);
    return response.data;
  },

  logout: async () => {
    const response = await apiClient.post('/logout');
    return response.data;
  },

  getMe: async () => {
    const response = await apiClient.get('/me');
    return response.data;
  },
};
```

### `src/api/mascotas.js`

```javascript
import apiClient from './client';

export const mascotasAPI = {
  getMascotas: async () => {
    const response = await apiClient.get('/mascotas');
    return response.data.mascotas;
  },

  createMascota: async (formData) => {
    const response = await apiClient.post('/mascotas', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    return response.data;
  },
};
```

### `src/api/citas.js`

```javascript
import apiClient from './client';

export const citasAPI = {
  getCitas: async () => {
    const response = await apiClient.get('/citas');
    return response.data.citas;
  },

  createCita: async (citaData) => {
    const response = await apiClient.post('/citas', citaData);
    return response.data;
  },

  cancelCita: async (citaId) => {
    const response = await apiClient.post(`/citas/${citaId}/cancel`);
    return response.data;
  },

  getVeterinarios: async () => {
    const response = await apiClient.get('/veterinarios');
    return response.data.veterinarios;
  },
};
```

---

## 🎨 Pantallas Principales

### 1. LoginScreen.jsx

```javascript
import React, { useState } from 'react';
import { View, TextInput, TouchableOpacity, Text, StyleSheet } from 'react-native';
import { authAPI } from '../api/auth';
import AsyncStorage from '@react-native-async-storage/async-storage';

export default function LoginScreen({ navigation }) {
  const [email, setEmail] = useState('cliente@rambopet.cl'); // Email predeterminado
  const [password, setPassword] = useState('cliente123');
  const [loading, setLoading] = useState(false);

  const handleLogin = async () => {
    try {
      setLoading(true);
      const data = await authAPI.login(email, password);

      // Guardar token
      await AsyncStorage.setItem('auth_token', data.token);
      await AsyncStorage.setItem('user', JSON.stringify(data.user));

      navigation.replace('Main');
    } catch (error) {
      alert('Error al iniciar sesión: ' + error.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>RamboPet</Text>
      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        onChangeText={setEmail}
        keyboardType="email-address"
        autoCapitalize="none"
      />
      <TextInput
        style={styles.input}
        placeholder="Contraseña"
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />
      <TouchableOpacity
        style={styles.button}
        onPress={handleLogin}
        disabled={loading}
      >
        <Text style={styles.buttonText}>
          {loading ? 'Cargando...' : 'Iniciar Sesión'}
        </Text>
      </TouchableOpacity>
      <TouchableOpacity onPress={() => navigation.navigate('Register')}>
        <Text style={styles.link}>¿No tienes cuenta? Regístrate</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 20,
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 32,
    fontWeight: 'bold',
    textAlign: 'center',
    marginBottom: 40,
    color: '#10b981',
  },
  input: {
    backgroundColor: 'white',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    borderWidth: 1,
    borderColor: '#ddd',
  },
  button: {
    backgroundColor: '#10b981',
    padding: 15,
    borderRadius: 10,
    alignItems: 'center',
    marginTop: 10,
  },
  buttonText: {
    color: 'white',
    fontSize: 16,
    fontWeight: 'bold',
  },
  link: {
    color: '#10b981',
    textAlign: 'center',
    marginTop: 20,
  },
});
```

### 2. AgendarCitaScreen.jsx

```javascript
import React, { useState, useEffect } from 'react';
import { View, Text, ScrollView, TouchableOpacity, StyleSheet } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import DateTimePicker from '@react-native-community/datetimepicker';
import { mascotasAPI, citasAPI } from '../api';

export default function AgendarCitaScreen({ navigation }) {
  const [mascotas, setMascotas] = useState([]);
  const [veterinarios, setVeterinarios] = useState([]);
  const [selectedMascota, setSelectedMascota] = useState('');
  const [selectedVeterinario, setSelectedVeterinario] = useState('');
  const [fecha, setFecha] = useState(new Date());
  const [tipoConsulta, setTipoConsulta] = useState('consulta_general');
  const [motivo, setMotivo] = useState('');

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    const [mascotasData, veterinariosData] = await Promise.all([
      mascotasAPI.getMascotas(),
      citasAPI.getVeterinarios(),
    ]);
    setMascotas(mascotasData);
    setVeterinarios(veterinariosData);
  };

  const handleSubmit = async () => {
    try {
      await citasAPI.createCita({
        mascota_id: selectedMascota,
        veterinario_id: selectedVeterinario,
        fecha_hora: fecha.toISOString(),
        tipo_consulta: tipoConsulta,
        motivo: motivo,
      });

      alert('¡Cita agendada exitosamente!');
      navigation.goBack();
    } catch (error) {
      alert('Error al agendar cita: ' + error.message);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Agendar Nueva Cita</Text>

      {/* Formulario completo aquí */}
      {/* Pickers para mascota, veterinario, tipo de consulta */}
      {/* DateTimePicker para fecha y hora */}
      {/* TextInput para motivo */}
      {/* Botón de submit */}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
});
```

---

## 📋 API Endpoints Disponibles

### Autenticación

- `POST /api/mobile/login` - Iniciar sesión
- `POST /api/mobile/register` - Registrar nuevo usuario
- `POST /api/mobile/logout` - Cerrar sesión
- `GET /api/mobile/me` - Obtener usuario autenticado

### Mascotas

- `GET /api/mobile/mascotas` - Listar mascotas del usuario
- `POST /api/mobile/mascotas` - Registrar nueva mascota (con foto)

### Citas

- `GET /api/mobile/citas` - Listar citas del usuario
- `POST /api/mobile/citas` - Agendar nueva cita
- `POST /api/mobile/citas/{id}/cancel` - Cancelar cita

### Otros

- `GET /api/mobile/veterinarios` - Listar veterinarios disponibles
- `GET /api/mobile/tutor/profile` - Obtener perfil del tutor

---

## 🔐 Credenciales de Prueba

**Usuario Cliente/Tutor:**
- Email: `cliente@rambopet.cl`
- Contraseña: `cliente123`

---

## 🎨 Mejoras Sugeridas

1. **Validación de Formularios**: Usar `react-hook-form` + `yup`
2. **Notificaciones Push**: Implementar Expo Notifications
3. **Cámara**: Tomar fotos directamente desde la app
4. **Chat**: Mensajería con el veterinario
5. **Pagos**: Integrar pasarela de pagos
6. **Historial Médico**: Ver episodios clínicos y recetas
7. **Recordatorios**: Notificaciones para citas y vacunas
8. **Mapa**: Ubicación de la clínica con Google Maps

---

## 📱 Probar en Dispositivo

1. Instala Expo Go en tu teléfono
2. Ejecuta `npx expo start` en la raíz del proyecto
3. Escanea el QR code con Expo Go

---

## 🐛 Troubleshooting

### Error de CORS

Si tienes problemas de CORS, agrega en Laravel `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'],
```

### Error de conexión

Asegúrate de usar tu IP local en vez de localhost:

```javascript
const API_URL = 'http://192.168.1.100:8000/api/mobile';
```

---

## 📚 Recursos Adicionales

- [Expo Documentation](https://docs.expo.dev/)
- [React Navigation](https://reactnavigation.org/)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Axios Documentation](https://axios-http.com/)

---

¡Listo! Ahora puedes desarrollar la app móvil completa usando este backend 🚀

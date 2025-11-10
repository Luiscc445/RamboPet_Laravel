# 📱 RamboPet Mobile App

App móvil React Native para clientes/tutores de RamboPet.

## 🚀 Instalación

### 1. Instalar dependencias

```bash
cd mobile
npm install
```

### 2. Configurar la URL del API

Tienes **dos opciones** para configurar la conexión al backend:

#### Opción A: Usar ngrok (Recomendado) 🌐

ngrok permite probar la app desde cualquier lugar sin necesidad de estar en la misma red WiFi.

**Ver la guía completa:** [NGROK_SETUP.md](../NGROK_SETUP.md) en la raíz del proyecto.

**Configuración rápida:**

1. Instala ngrok: https://ngrok.com/download
2. Ejecuta en la raíz del proyecto (Windows):
   ```cmd
   start-dev.bat
   ```
3. Copia la URL HTTPS de ngrok (ej: `https://xxxx-xxxx.ngrok-free.dev`)
4. Edita `src/utils/constants.js`:
   ```javascript
   export const API_BASE_URL = 'https://TU-URL-NGROK/api/mobile';
   ```

#### Opción B: Usar IP local (Solo misma red WiFi) 📡

Edita `src/utils/constants.js` y cambia la IP a la de tu computadora:

```javascript
// Encuentra tu IP local:
// Windows: ipconfig
// Mac/Linux: ifconfig o ip addr

export const API_BASE_URL = 'http://TU_IP_LOCAL:8000/api/mobile';
// Ejemplo: http://192.168.0.72:8000/api/mobile
```

⚠️ **Importante:** Tu teléfono y PC deben estar en la misma red WiFi.

### 3. Iniciar el servidor Laravel

Asegúrate de que el backend Laravel esté corriendo:

```bash
cd ..  # Volver a la raíz del proyecto
php artisan serve --host=0.0.0.0 --port=8000
```

### 4. Ejecutar la app

```bash
cd mobile
npm start
# o
npx expo start
```

### 5. Probar en tu dispositivo

1. **Instala Expo Go** en tu teléfono (iOS o Android)
2. **Escanea el QR** que aparece en la terminal
3. **Espera** a que se cargue la app

---

## 🔐 Credenciales de Prueba

**Usuario Cliente:**
- Email: `cliente@rambopet.cl`
- Contraseña: `cliente123`

---

## 📱 Funcionalidades

### ✅ Autenticación
- Login con email y contraseña
- Registro de nuevos usuarios
- Cierre de sesión

### ✅ Mascotas
- Ver lista de mascotas
- Registrar nueva mascota
- Subir foto de mascota
- Editar información

### ✅ Citas
- Ver historial de citas
- Agendar nueva cita
- Seleccionar veterinario
- Cancelar citas
- Ver estado de citas

### ✅ Perfil
- Ver información personal
- Cerrar sesión

---

## 📁 Estructura del Proyecto

```
mobile/
├── src/
│   ├── api/                 # Cliente API y endpoints
│   │   ├── client.js       # Configuración Axios
│   │   ├── auth.js         # Autenticación
│   │   ├── mascotas.js     # Mascotas
│   │   ├── citas.js        # Citas
│   │   └── index.js
│   ├── screens/            # Pantallas de la app
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
│   ├── navigation/
│   │   └── AppNavigator.jsx
│   └── utils/
│       └── constants.js    # Configuración
├── App.js
├── package.json
└── README.md
```

---

## 🛠️ Tecnologías Utilizadas

- **React Native** - Framework móvil
- **Expo** - Plataforma de desarrollo
- **React Navigation** - Navegación
- **Axios** - Cliente HTTP
- **AsyncStorage** - Almacenamiento local
- **Expo Image Picker** - Selector de imágenes
- **Date-fns** - Manejo de fechas
- **Ionicons** - Iconos

---

## 🌐 Endpoints API Utilizados

### Autenticación
- `POST /mobile/login` - Iniciar sesión
- `POST /mobile/register` - Registro
- `POST /mobile/logout` - Cerrar sesión
- `GET /mobile/me` - Usuario actual

### Mascotas
- `GET /mobile/mascotas` - Listar mascotas
- `POST /mobile/mascotas` - Crear mascota (con foto)
- `GET /mobile/tutor/profile` - Perfil del tutor

### Citas
- `GET /mobile/citas` - Listar citas
- `POST /mobile/citas` - Crear cita
- `POST /mobile/citas/{id}/cancel` - Cancelar cita
- `GET /mobile/veterinarios` - Listar veterinarios

---

## 🐛 Troubleshooting

### Error de conexión

Si no puedes conectarte al backend:

1. **Verifica que Laravel esté corriendo** con `--host=0.0.0.0`
2. **Usa tu IP local**, no `localhost` ni `127.0.0.1`
3. **Verifica el firewall** de tu computadora
4. **Asegúrate** que tu teléfono y PC estén en la misma red Wi-Fi

### Error de CORS

Si ves errores de CORS en la consola:

1. Ve a `config/cors.php` en Laravel
2. Asegúrate que esté configurado correctamente:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Imágenes no se suben

Si las imágenes de mascotas no se suben:

1. Verifica que el directorio `storage/app/public/mascotas` exista
2. Ejecuta: `php artisan storage:link`
3. Verifica permisos de escritura en `storage/`

---

## 📦 Build para Producción

### Android

```bash
eas build --platform android
```

### iOS

```bash
eas build --platform ios
```

Necesitarás configurar EAS (Expo Application Services) primero.

---

## 🎨 Personalización

### Cambiar colores

Edita `src/utils/constants.js` y los estilos en cada pantalla.

### Agregar nuevas funcionalidades

1. Crea el endpoint en el backend Laravel
2. Agrega la función en `/src/api/`
3. Crea o actualiza la pantalla correspondiente
4. Agrega la ruta en `AppNavigator.jsx`

---

## 📚 Recursos

- [Expo Documentation](https://docs.expo.dev/)
- [React Native Docs](https://reactnative.dev/)
- [React Navigation](https://reactnavigation.org/)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)

---

## ✨ Características Futuras

- [ ] Notificaciones push
- [ ] Chat con veterinario
- [ ] Historial médico detallado
- [ ] Recordatorios de vacunas
- [ ] Pagos integrados
- [ ] Mapa de ubicación
- [ ] Modo offline

---

¡Listo para usar! 🚀

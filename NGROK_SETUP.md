# 🚀 Guía de Configuración con ngrok - RamboPet

Esta guía te ayudará a configurar y ejecutar la aplicación móvil RamboPet usando ngrok para desarrollo y testing.

## 📋 Requisitos Previos

Asegúrate de tener instalado:

- ✅ **PHP 8.2+** (XAMPP o instalación standalone)
- ✅ **Composer**
- ✅ **Node.js 18+** y npm
- ✅ **ngrok** - [Descargar aquí](https://ngrok.com/download)
- ✅ **Expo Go** en tu teléfono móvil
  - [Android](https://play.google.com/store/apps/details?id=host.exp.exponent)
  - [iOS](https://apps.apple.com/app/expo-go/id982107779)

## 🎯 ¿Qué es ngrok?

ngrok crea un túnel HTTPS público que apunta a tu servidor local. Esto permite:
- Probar la app móvil desde cualquier dispositivo sin estar en la misma red WiFi
- Tener una URL HTTPS real para desarrollo
- Compartir tu aplicación con otros para testing

## 🔧 Configuración Inicial (Primera vez)

### Opción 1: Script Automático (Recomendado para Windows)

1. Ejecuta el script de inicio:
```cmd
start-dev.bat
```

Este script:
- ✅ Verifica todas las instalaciones necesarias
- ✅ Configura el authtoken de ngrok automáticamente
- ✅ Inicia el backend Laravel
- ✅ Inicia el túnel ngrok
- ✅ Te guía para configurar la app móvil

### Opción 2: Configuración Manual

#### Paso 1: Configurar ngrok authtoken

**Windows:**
```cmd
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG
```

**Linux/Mac:**
```bash
./setup-ngrok.sh
```

O manualmente:
```bash
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG
```

#### Paso 2: Instalar dependencias

**Backend Laravel:**
```bash
composer install
```

**App Móvil:**
```bash
cd mobile
npm install
```

## 🚀 Inicio de Desarrollo

### 1. Iniciar Backend Laravel

En una terminal (en la raíz del proyecto):

```bash
php artisan serve
```

El backend estará disponible en: `http://127.0.0.1:8000`

### 2. Iniciar túnel ngrok

En **otra terminal**:

**Windows:**
```cmd
setup-ngrok.bat
```

**Linux/Mac:**
```bash
./setup-ngrok.sh
```

O manualmente:
```bash
ngrok http 8000
```

Verás algo como:
```
Session Status                online
Account                       Your Account
Version                       3.x.x
Region                        United States (us)
Latency                       45ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://xxxx-xxxx-xxxx.ngrok-free.dev -> http://localhost:8000
```

**¡IMPORTANTE!** Copia la URL HTTPS (ej: `https://xxxx-xxxx-xxxx.ngrok-free.dev`)

### 3. Configurar la App Móvil con la URL de ngrok

Edita el archivo `mobile/src/utils/constants.js`:

```javascript
// Cambia esta línea con tu URL de ngrok:
export const API_BASE_URL = 'https://TU-URL-NGROK-AQUI/api/mobile';

// Ejemplo:
export const API_BASE_URL = 'https://nonspecialized-unstatistically-eliza.ngrok-free.dev/api/mobile';
```

### 4. Iniciar la App Móvil

En **otra terminal** (en la carpeta `mobile`):

```bash
cd mobile
npm start
```

Verás un QR code en la terminal.

### 5. Abrir en tu teléfono

1. Abre **Expo Go** en tu teléfono
2. Escanea el **QR code**
3. La app se cargará automáticamente

## 🔑 Credenciales de Prueba

```
Email: cliente@rambopet.cl
Contraseña: cliente123
```

## 🔍 Verificar que todo funcione

### Backend Laravel

Visita en tu navegador:
```
http://127.0.0.1:8000/api/mobile/veterinarios
```

Deberías ver un JSON con la lista de veterinarios (puede estar vacío si no hay datos).

### Túnel ngrok

Visita en tu navegador:
```
https://TU-URL-NGROK/api/mobile/veterinarios
```

Deberías ver el mismo resultado que en local.

### Panel de Control de ngrok

Visita: `http://127.0.0.1:4040`

Aquí puedes ver todas las peticiones HTTP en tiempo real.

## 🛠️ Solución de Problemas

### Error: "ngrok: command not found"

**Solución:**
1. Descarga ngrok: https://ngrok.com/download
2. Descomprime el archivo
3. Agrega ngrok al PATH del sistema o mueve el ejecutable a una carpeta en el PATH

### Error: "Failed to connect to backend"

**Verificar:**
1. ✅ El backend Laravel está corriendo (`php artisan serve`)
2. ✅ El túnel ngrok está activo
3. ✅ La URL en `constants.js` es correcta y termina en `/api/mobile`
4. ✅ No hay errores en la consola de Laravel

### Error: "ngrok-skip-browser-warning"

**Solución:** Ya está configurado automáticamente. El header `ngrok-skip-browser-warning: true` se envía en cada petición desde la app móvil.

### Error: "CORS policy blocked"

**Solución:** Ya está configurado. Verifica que el middleware `HandleNgrokHeaders` esté activo en `bootstrap/app.php`.

### La app no se conecta al backend

**Pasos de verificación:**
1. Verifica que la URL de ngrok esté actualizada en `constants.js`
2. Reinicia la app móvil (cierra y vuelve a abrir en Expo Go)
3. Verifica que el backend responda en: `https://TU-URL/api/mobile/me`

### Cambió la URL de ngrok

**Normal:** La URL de ngrok cambia cada vez que reinicias el túnel (con cuenta gratuita).

**Solución:**
1. Copia la nueva URL de la terminal de ngrok
2. Actualiza `mobile/src/utils/constants.js`
3. Reinicia Expo (`r` en la terminal de npm start)

## 📱 Testing de Funcionalidades

### 1. Login
- ✅ Iniciar sesión con: `cliente@rambopet.cl` / `cliente123`
- ✅ Verificar que te redirija al Home

### 2. Home
- ✅ Ver estadísticas de mascotas
- ✅ Ver próximas citas
- ✅ Carousel de mascotas

### 3. Mascotas
- ✅ Ver lista de mascotas
- ✅ Agregar nueva mascota (con foto)
- ✅ Subir foto desde galería

### 4. Citas
- ✅ Ver lista de citas
- ✅ Agendar nueva cita
- ✅ Cancelar cita
- ✅ Ver estados con colores

### 5. Perfil
- ✅ Ver datos del usuario
- ✅ Cerrar sesión

## 🌐 Desarrollo en Red Local (Alternativa sin ngrok)

Si prefieres trabajar solo en tu red WiFi local, puedes usar tu IP local:

1. Encuentra tu IP: `ipconfig` (Windows) o `ifconfig` (Linux/Mac)
2. Edita `mobile/src/utils/constants.js`:

```javascript
// Descomenta esta línea y comenta la de ngrok:
export const API_BASE_URL = 'http://192.168.0.72:8000/api/mobile';
```

3. Asegúrate de que tu teléfono esté en la misma red WiFi

## 📊 Monitoreo

### Logs del Backend
En la terminal donde corre `php artisan serve`:
```
[timestamp] GET /api/mobile/mascotas ...................... 200
[timestamp] POST /api/mobile/citas ....................... 201
```

### Logs de ngrok
Visita: `http://127.0.0.1:4040/inspect/http`

Aquí puedes ver:
- Todas las peticiones HTTP
- Headers enviados y recibidos
- Tiempos de respuesta
- Códigos de estado

### Logs de Expo
En la terminal donde corre `npm start`:
```
› Opening exp://192.168.x.x:8081 on iPhone
› Metro waiting on exp://192.168.x.x:8081
```

## 🔄 Actualizar la App

Si haces cambios en el código:

**Frontend (React Native):**
- La app se recargará automáticamente (hot reload)
- O presiona `r` en la terminal de Expo para recargar manualmente

**Backend (Laravel):**
- Los cambios se reflejan automáticamente
- Si modificas rutas o configuración, reinicia el servidor

## 📂 Estructura de Archivos Relacionados

```
RamboPet_Laravel/
├── mobile/
│   ├── assets/                    # Assets generados
│   │   ├── icon.png              # Icono de la app (1024x1024)
│   │   ├── favicon.png           # Favicon (48x48)
│   │   ├── splash.png            # Splash screen (1284x2778)
│   │   └── adaptive-icon.png     # Icono Android (512x512)
│   ├── src/
│   │   ├── api/
│   │   │   └── client.js         # Configuración de axios con ngrok header
│   │   └── utils/
│   │       └── constants.js      # URL del API (EDITAR AQUÍ)
│   └── generate_assets.py        # Script para regenerar assets
├── app/Http/Middleware/
│   └── HandleNgrokHeaders.php    # Middleware para CORS con ngrok
├── config/
│   └── cors.php                  # Configuración CORS
├── setup-ngrok.bat               # Script Windows para ngrok
├── setup-ngrok.sh                # Script Linux/Mac para ngrok
├── start-dev.bat                 # Script completo de inicio (Windows)
└── NGROK_SETUP.md                # Esta guía
```

## 💡 Tips y Mejores Prácticas

1. **Mantén ngrok corriendo**: No cierres la terminal de ngrok mientras desarrollas
2. **Guarda la URL**: La URL de ngrok cambia, guárdala mientras trabajas
3. **Usa el panel de ngrok**: `http://127.0.0.1:4040` es muy útil para debugging
4. **Credenciales por defecto**: La app viene con credenciales pre-cargadas
5. **Pull to refresh**: Arrastra hacia abajo en las listas para actualizar datos
6. **Hot reload**: Los cambios en React Native se ven instantáneamente

## 🆘 Soporte

Si encuentras problemas:

1. **Revisa los logs** en todas las terminales
2. **Verifica el panel de ngrok**: `http://127.0.0.1:4040`
3. **Reinicia todo**: A veces es la solución más rápida
   - Detén Laravel (Ctrl+C)
   - Detén ngrok (Ctrl+C)
   - Detén Expo (Ctrl+C)
   - Vuelve a ejecutar `start-dev.bat`

## 🎉 ¡Listo!

Ahora tienes un entorno de desarrollo completo con ngrok. Puedes desarrollar y probar tu app desde cualquier lugar.

**Happy coding! 🚀**

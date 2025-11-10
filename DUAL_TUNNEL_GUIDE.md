# 🚀 Guía de Doble Túnel ngrok - RamboPet

Esta guía te muestra cómo ejecutar **dos túneles ngrok simultáneos**:
1. **Túnel Backend** (Laravel API) - Puerto 8000
2. **Túnel Frontend** (React Native Web) - Puerto 8081

## 📋 Ventajas del Sistema Dual

✅ **Backend separado del Frontend**
- El backend Laravel tiene su propia URL pública
- El frontend React Native tiene su propia URL pública

✅ **Acceso desde navegador**
- Puedes ver la app móvil en el navegador web
- No necesitas Expo Go para probar

✅ **Compartir fácilmente**
- Comparte la URL del frontend con otros
- Pruebas en múltiples dispositivos sin configuración

✅ **Debugging mejorado**
- Inspecciona peticiones HTTP de ambos servicios
- Panel de ngrok separado para cada túnel

---

## 🎯 Arquitectura del Sistema

```
┌─────────────────────────────────────────────┐
│          DOBLE TÚNEL NGROK                  │
├─────────────────────────────────────────────┤
│                                             │
│  Túnel 1: Backend (Laravel)                 │
│  https://backend-xxx.ngrok-free.dev         │
│          ↓                                  │
│  localhost:8000 (API REST)                  │
│                                             │
├─────────────────────────────────────────────┤
│                                             │
│  Túnel 2: Frontend (React Native Web)       │
│  https://frontend-yyy.ngrok-free.dev        │
│          ↓                                  │
│  localhost:8081 (Metro Bundler + Web)       │
│                                             │
└─────────────────────────────────────────────┘

Usuario/Teléfono
      ↓
[Abre URL Frontend]
      ↓
[App React Native]
      ↓
[Consume API Backend]
```

---

## 🚀 Inicio Rápido (Automático)

### Opción 1: Script Todo-en-Uno (Recomendado)

Este script inicia **AUTOMÁTICAMENTE** todo lo que necesitas:

```cmd
start-all.bat
```

**¿Qué hace este script?**
1. ✅ Verifica instalaciones (PHP, Node.js, ngrok)
2. ✅ Configura authtoken de ngrok
3. ✅ Inicia backend Laravel (puerto 8000)
4. ✅ Inicia frontend React Native Web (puerto 8081)
5. ✅ Inicia doble túnel ngrok
6. ✅ Abre 3 ventanas de terminal

**Resultado:**
- Terminal 1: Backend Laravel corriendo
- Terminal 2: Frontend React Native Web corriendo
- Terminal 3: ngrok con 2 túneles activos

### Opción 2: Solo Túneles ngrok

Si ya tienes Laravel y React Native corriendo:

```cmd
start-ngrok-dual.bat
```

O en Linux/Mac:

```bash
./start-ngrok-dual.sh
```

---

## 📝 Inicio Manual (Paso a Paso)

### Paso 1: Iniciar Backend Laravel

**Terminal 1:**

```bash
cd C:\VeterinariaLaravelito
php artisan serve
```

Deberías ver:
```
Laravel development server started: http://127.0.0.1:8000
```

### Paso 2: Iniciar Frontend React Native

**Terminal 2:**

```bash
cd C:\VeterinariaLaravelito\mobile
npm run web
```

Deberías ver:
```
Metro waiting on exp://127.0.0.1:8081
```

### Paso 3: Iniciar Doble Túnel ngrok

**Terminal 3:**

```bash
cd C:\VeterinariaLaravelito
ngrok start --all --config ngrok.yml
```

Verás algo como:

```
Session Status                online
Account                       Your Account
Version                       3.x.x

Web Interface                 http://127.0.0.1:4040

Forwarding                    https://abc123.ngrok-free.dev -> http://localhost:8000
Forwarding                    https://xyz789.ngrok-free.dev -> http://localhost:8081

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**¡IMPORTANTE!** Copia ambas URLs:
- `https://abc123.ngrok-free.dev` → **Backend Laravel**
- `https://xyz789.ngrok-free.dev` → **Frontend React Native**

---

## 🔧 Configuración de URLs

### Actualizar URL del Backend en la App

Edita `mobile/src/utils/constants.js`:

```javascript
// Cambia esta línea con la URL del túnel "backend"
export const API_BASE_URL = 'https://abc123.ngrok-free.dev/api/mobile';
```

**Luego recarga la app:**
- En el navegador: Refresca la página (F5)
- En Expo Go: Presiona `r` en la terminal

---

## 🌐 Cómo Acceder a la App

### Opción 1: Desde el Navegador (Web)

1. Abre tu navegador
2. Ve a la **URL del Frontend** (la segunda URL de ngrok)
3. Ejemplo: `https://xyz789.ngrok-free.dev`
4. ✨ **Verás la app móvil funcionando en el navegador**

**Credenciales:**
- Email: `cliente@rambopet.cl`
- Contraseña: `cliente123`

### Opción 2: Desde el Teléfono (Expo Go)

1. Instala **Expo Go** en tu teléfono
2. Escanea el **QR** que aparece en la Terminal 2
3. La app se cargará en tu teléfono
4. Inicia sesión con las mismas credenciales

### Opción 3: Compartir con Otros

Simplemente comparte la **URL del Frontend**:
```
https://xyz789.ngrok-free.dev
```

Cualquier persona podrá:
- Abrir la URL en su navegador
- Ver y probar la app móvil
- Iniciar sesión y registrar mascotas/citas

---

## 🔍 Verificación y Testing

### Test 1: Backend API funciona

Visita en el navegador:
```
https://abc123.ngrok-free.dev/api/mobile/veterinarios
```

Deberías ver JSON con la lista de veterinarios.

### Test 2: Frontend carga

Visita en el navegador:
```
https://xyz789.ngrok-free.dev
```

Deberías ver la pantalla de login de la app móvil.

### Test 3: Integración completa

1. Abre la URL del frontend
2. Inicia sesión: `cliente@rambopet.cl` / `cliente123`
3. Ve a "Mascotas" y agrega una mascota
4. La mascota se guarda en el backend Laravel
5. ✅ Todo funciona correctamente

---

## 📊 Panel de Inspección ngrok

Visita: `http://127.0.0.1:4040`

Aquí puedes ver:
- Todas las peticiones HTTP a ambos túneles
- Headers enviados y recibidos
- Tiempos de respuesta
- Códigos de estado
- Replay de peticiones

**Filtrar por túnel:**
- Selecciona "backend" o "frontend" en el dropdown

---

## ⚙️ Configuración Avanzada

### Archivo de Configuración ngrok.yml

El archivo `ngrok.yml` en la raíz del proyecto define ambos túneles:

```yaml
version: "2"
authtoken: TU_AUTHTOKEN

tunnels:
  backend:
    proto: http
    addr: 8000
    inspect: true
    bind_tls: true

  frontend:
    proto: http
    addr: 8081
    inspect: true
    bind_tls: true
```

**Parámetros:**
- `proto: http` - Protocolo HTTP
- `addr: 8000/8081` - Puertos locales
- `inspect: true` - Habilita inspección de peticiones
- `bind_tls: true` - Solo HTTPS (no HTTP)

### Cambiar Puertos

Si necesitas usar otros puertos, edita `ngrok.yml` y los comandos de inicio:

1. Cambia `addr: 8000` por tu puerto de Laravel
2. Cambia `addr: 8081` por tu puerto de Expo
3. Actualiza los scripts de inicio

---

## 🛠️ Solución de Problemas

### Error: "Failed to start tunnel"

**Causa:** ngrok ya está corriendo

**Solución:**
```bash
# Mata procesos de ngrok
taskkill /F /IM ngrok.exe

# O en Linux/Mac
killall ngrok

# Luego reinicia
start-ngrok-dual.bat
```

### Error: "Port already in use"

**Causa:** Laravel o Expo ya están corriendo

**Solución:**
```bash
# Ver qué proceso usa el puerto 8000
netstat -ano | findstr :8000

# Matar el proceso (Windows)
taskkill /F /PID <PID>

# O en Linux/Mac
lsof -ti:8000 | xargs kill
```

### Las URLs de ngrok cambiaron

**Normal:** Con cuenta gratuita las URLs cambian cada vez

**Solución:**
1. Copia las nuevas URLs de la terminal de ngrok
2. Actualiza `mobile/src/utils/constants.js` con la URL del backend
3. Recarga la app (F5 en navegador, `r` en Expo)

### La app no se conecta al backend

**Verificar:**
1. ✅ Laravel está corriendo
2. ✅ ngrok muestra ambos túneles activos
3. ✅ URL del backend está correcta en `constants.js`
4. ✅ URL termina en `/api/mobile`

**Test rápido:**
```bash
# Probar endpoint directamente
curl https://abc123.ngrok-free.dev/api/mobile/veterinarios
```

### Error de CORS

**Ya está configurado**, pero si persiste:

1. Verifica que `HandleNgrokHeaders.php` esté en `app/Http/Middleware/`
2. Verifica que esté registrado en `bootstrap/app.php`
3. Limpia caché: `php artisan config:clear`

---

## 💡 Tips y Mejores Prácticas

### 1. Usar el Script Todo-en-Uno

El script `start-all.bat` es la forma más fácil de iniciar todo:
```cmd
start-all.bat
```

### 2. Mantener las Terminales Abiertas

No cierres las 3 terminales mientras desarrollas:
- Terminal 1: Laravel
- Terminal 2: React Native
- Terminal 3: ngrok

### 3. Hot Reload Funciona

Los cambios en el código se reflejan automáticamente:
- **React Native:** Hot reload instantáneo
- **Laravel:** Cambios se aplican sin reiniciar

### 4. Guardar las URLs

Mientras trabajas, guarda las URLs de ngrok en un archivo temporal:

```bash
# backend.txt
https://abc123.ngrok-free.dev

# frontend.txt
https://xyz789.ngrok-free.dev
```

### 5. Compartir para Testing

Comparte la URL del frontend con testers:
- No necesitan instalar nada
- Solo abren el link en el navegador
- Pueden probar en móvil o desktop

---

## 🎨 Diferencias Web vs Móvil

### Versión Web (Navegador)
- ✅ Funciona en cualquier navegador moderno
- ✅ No requiere instalación
- ✅ Ideal para demos y testing rápido
- ⚠️ Algunas funciones nativas pueden no funcionar (cámara, notificaciones)

### Versión Móvil (Expo Go)
- ✅ Funcionalidad completa
- ✅ Acceso a cámara y galería
- ✅ Notificaciones push (con configuración)
- ⚠️ Requiere instalar Expo Go

---

## 📁 Archivos Importantes

```
RamboPet_Laravel/
├── ngrok.yml                    # Configuración de doble túnel
├── start-all.bat                # Script todo-en-uno
├── start-ngrok-dual.bat         # Solo túneles ngrok (Windows)
├── start-ngrok-dual.sh          # Solo túneles ngrok (Linux/Mac)
├── DUAL_TUNNEL_GUIDE.md         # Esta guía
├── mobile/
│   ├── src/utils/constants.js   # URL del backend (EDITAR AQUÍ)
│   ├── webpack.config.js        # Configuración web
│   └── package.json             # Dependencias web agregadas
└── app/Http/Middleware/
    └── HandleNgrokHeaders.php   # Middleware CORS para ngrok
```

---

## 🆘 Soporte y Ayuda

### Comandos Útiles

```bash
# Ver estado de ngrok
ngrok config check

# Ver configuración de ngrok
ngrok config edit

# Ver logs de Laravel
php artisan serve --verbose

# Ver logs de Expo
npm run web -- --verbose
```

### Reiniciar Todo

Si algo no funciona, reinicia todo:

1. Cierra todas las terminales (Ctrl+C en cada una)
2. Ejecuta de nuevo: `start-all.bat`
3. Espera a que todo se inicie
4. Copia las nuevas URLs de ngrok
5. Actualiza `constants.js` si es necesario

---

## 🎉 ¡Listo!

Ahora tienes un sistema completo con:
- ✅ Backend Laravel accesible públicamente
- ✅ Frontend React Native accesible desde navegador
- ✅ App móvil en Expo Go
- ✅ Doble túnel ngrok para desarrollo remoto
- ✅ Scripts automatizados para inicio rápido

**¡Feliz desarrollo! 🚀**

# 🐾 RamboPet - Guía de Configuración e Inicio

Guía completa para configurar y ejecutar RamboPet (Sistema Veterinario Laravel + App Móvil React Native)

---

## 📋 Requisitos Previos

### Software Necesario:
- **PHP 8.2+** (XAMPP o instalación nativa)
- **Composer** (gestor de dependencias PHP)
- **Node.js 18+** y **npm**
- **Supabase** (Base de datos PostgreSQL en la nube - ya configurada)

### Verificar Instalaciones:
```bash
php --version
composer --version
node --version
npm --version
```

---

## 🚀 Inicio Rápido

### **Windows:**

**Terminal 1 - Backend Laravel:**
```cmd
start-backend.bat
```

**Terminal 2 - App Móvil:**
```cmd
start-mobile.bat
```

**Terminal 3 - Túnel Web (Opcional):**
```cmd
start-tunnel.bat
```

### **Linux/Mac:**

**Terminal 1 - Backend Laravel:**
```bash
./start-backend.sh
```

**Terminal 2 - App Móvil:**
```bash
./start-mobile.sh
```

**Terminal 3 - Túnel Web (Opcional):**
```bash
./start-tunnel.sh
```

---

## 📦 Instalación Inicial (Solo Primera Vez)

### 1. Backend Laravel

```bash
# Instalar dependencias PHP
composer install

# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar Supabase en .env
# DB_CONNECTION=pgsql
# DB_HOST=tu-proyecto.supabase.co
# DB_PORT=5432
# DB_DATABASE=postgres
# DB_USERNAME=postgres
# DB_PASSWORD=tu-password

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (crear usuarios y datos de prueba)
php artisan db:seed
```

### 2. App Móvil React Native

```bash
# Ir a la carpeta mobile
cd mobile

# Instalar dependencias
npm install

# Volver a la raíz
cd ..
```

---

## 🖥️ Uso del Sistema

### **Backend Laravel (Puerto 8000)**

Ejecutar:
```bash
php artisan serve --port=8000
```

El backend estará disponible en:
- API: `http://localhost:8000/api`
- Panel Admin (Filament): `http://localhost:8000/admin`

**Credenciales de Admin:**
- Email: `admin@rambopet.cl`
- Password: `admin123`

---

### **App Móvil React Native (Puerto 8081)**

Ejecutar:
```bash
cd mobile
npm start
```

Opciones disponibles:
1. **Navegador Web:** Presiona `w` en la terminal
2. **Android/iOS:** Escanea el QR con la app **Expo Go**
3. **Android Emulator:** Presiona `a` en la terminal
4. **iOS Simulator:** Presiona `i` en la terminal (solo Mac)

**Credenciales de Cliente:**
- Email: `cliente@rambopet.cl`
- Password: `cliente123`

---

### **Túnel Web Público (Localtunnel)**

Para probar la app móvil desde cualquier navegador web (público):

```bash
cd mobile
npm run tunnel
```

Recibirás una URL pública como: `https://xxxx.loca.lt`

**Características:**
- ✅ Gratis y sin límites
- ✅ No requiere instalación ni registro
- ✅ Expone el puerto 8081 (app móvil)
- ⚠️ La URL cambia cada vez que inicias el túnel

**Uso:**
1. Inicia el backend: `php artisan serve --port=8000`
2. Inicia la app móvil: `cd mobile && npm start`
3. Inicia el túnel: `cd mobile && npm run tunnel`
4. Abre la URL generada en tu navegador

---

## 🔧 Configuración de la App Móvil

### Archivo: `mobile/src/utils/constants.js`

```javascript
// Backend local (recomendado para desarrollo)
export const API_BASE_URL = 'http://localhost:8000/api/mobile';

// O usar IP local para probar desde otro dispositivo
// export const API_BASE_URL = 'http://192.168.0.72:8000/api/mobile';
```

**Para obtener tu IP local:**
- Windows: `ipconfig`
- Linux/Mac: `ifconfig` o `ip addr`

---

## 📱 Pantallas de la App Móvil

La app incluye:
- 🔐 **Login/Registro** - Autenticación de tutores
- 🏠 **Home** - Dashboard con resumen
- 🐕 **Mis Mascotas** - Lista y registro de mascotas
- 📅 **Mis Citas** - Ver y agendar citas veterinarias
- 👤 **Perfil** - Información del tutor y logout

---

## 🛠️ Solución de Problemas

### Error: "Connection refused" en la app móvil

**Problema:** La app no se conecta al backend.

**Solución:**
1. Verifica que Laravel esté corriendo: `http://localhost:8000`
2. Si usas Android/iOS físico, cambia `localhost` por tu IP local en `constants.js`
3. Si usas emulador Android, usa `10.0.2.2:8000` en vez de `localhost:8000`

### Error: Puerto 8000 o 8081 en uso

**Solución:**
```bash
# Windows
netstat -ano | findstr :8000
taskkill /PID <PID> /F

# Linux/Mac
lsof -ti:8000 | xargs kill -9
lsof -ti:8081 | xargs kill -9
```

### Error: Migraciones de Laravel

```bash
# Limpiar y recrear base de datos
php artisan migrate:fresh --seed
```

### Error: Dependencias de Node.js

```bash
cd mobile
rm -rf node_modules package-lock.json
npm install
```

---

## 🌐 Estructura del Proyecto

```
RamboPet_Laravel/
├── app/                    # Código Laravel
│   ├── Http/
│   │   └── Controllers/
│   │       └── Mobile/     # API para app móvil
│   └── Models/             # Modelos Eloquent
├── database/
│   ├── migrations/         # Migraciones SQL
│   └── seeders/            # Datos de prueba
├── mobile/                 # App React Native
│   ├── src/
│   │   ├── screens/        # Pantallas
│   │   ├── navigation/     # Navegación
│   │   ├── api/            # Servicios API
│   │   ├── contexts/       # Contextos React
│   │   └── utils/          # Utilidades y constantes
│   └── package.json
├── routes/
│   └── api.php             # Rutas API
├── start-backend.bat       # Iniciar Laravel (Windows)
├── start-mobile.bat        # Iniciar app móvil (Windows)
├── start-tunnel.bat        # Iniciar túnel web (Windows)
└── SETUP_GUIDE.md          # Esta guía
```

---

## 📚 Recursos Adicionales

- **Laravel:** https://laravel.com/docs
- **Filament:** https://filamentphp.com/docs
- **React Native:** https://reactnative.dev/docs
- **Expo:** https://docs.expo.dev/
- **Localtunnel:** https://github.com/localtunnel/localtunnel
- **Supabase:** https://supabase.com/docs

---

## ✅ Checklist de Desarrollo

### Backend Laravel:
- [ ] Migraciones ejecutadas
- [ ] Seeders ejecutados (usuarios de prueba)
- [ ] Servidor corriendo en puerto 8000
- [ ] Panel admin accesible en `/admin`
- [ ] API respondiendo en `/api`

### App Móvil:
- [ ] Dependencias instaladas (`npm install`)
- [ ] Metro Bundler corriendo (puerto 8081)
- [ ] Configuración de API correcta en `constants.js`
- [ ] Login funcional con credenciales de prueba
- [ ] Navegación entre pantallas funcionando

### Túnel Web (Opcional):
- [ ] Localtunnel corriendo
- [ ] URL pública generada
- [ ] App accesible desde navegador web

---

## 📞 Soporte

Si encuentras problemas:
1. Revisa la sección **Solución de Problemas**
2. Verifica los logs de Laravel: `storage/logs/laravel.log`
3. Revisa la consola del navegador (F12)
4. Verifica la terminal donde corre Metro Bundler

---

**¡Listo para desarrollar! 🚀**

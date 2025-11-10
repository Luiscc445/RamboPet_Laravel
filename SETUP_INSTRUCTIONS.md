# 🚀 Instrucciones de Configuración - RamboPet API

## 📋 Requisitos Previos

- PHP >= 8.1
- Composer
- Base de datos PostgreSQL (Supabase)
- Node.js y npm (para la app móvil)

## ⚙️ Configuración del Backend Laravel

### 1. Instalar Dependencias

```bash
cd RamboPet_Laravel
composer install
```

### 2. Configurar Variables de Entorno

Copia el archivo `.env.example` y crea tu `.env`:

```bash
copy .env.example .env   # Windows
# o
cp .env.example .env     # Linux/Mac
```

Edita el archivo `.env` con tus datos de Supabase:

```env
APP_NAME="RamboPet Veterinary System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=aws-0-us-east-1.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.TU_PROJECT_REF
DB_PASSWORD=TU_PASSWORD

CACHE_STORE=file
SESSION_DRIVER=file
```

**IMPORTANTE:** Cambia `CACHE_STORE=database` a `CACHE_STORE=file` para evitar errores de conexión durante la instalación.

### 3. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 4. Crear Directorios Necesarios

```bash
# Windows PowerShell
New-Item -ItemType Directory -Force -Path storage/framework/sessions
New-Item -ItemType Directory -Force -Path storage/framework/views
New-Item -ItemType Directory -Force -Path storage/framework/cache
New-Item -ItemType Directory -Force -Path storage/logs
New-Item -ItemType Directory -Force -Path bootstrap/cache

# Linux/Mac
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

### 5. Ejecutar Migraciones

```bash
php artisan migrate
```

### 6. Cargar Datos Iniciales (Seeders)

```bash
php artisan db:seed --class=EspecieRazaSeeder
php artisan db:seed --class=UserSeeder
```

### 7. Crear Storage Link (para imágenes)

```bash
php artisan storage:link
```

### 8. Iniciar el Servidor

```bash
php artisan serve
```

El servidor estará disponible en: `http://localhost:8000`

## 🧪 Probar la API

### Con PowerShell (Windows)

```powershell
# Registro de tutor
$body = @{
    name = "Juan Pérez"
    email = "juan@test.com"
    password = "12345678"
    password_confirmation = "12345678"
    telefono = "+56912345678"
    rut = "11111111-1"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "http://localhost:8000/api/mobile/register" -Method POST -Body $body -ContentType "application/json"
$data = $response.Content | ConvertFrom-Json
$token = $data.token

# Ver especies (usa el token que recibiste)
$headers = @{
    Authorization = "Bearer $token"
    Accept = "application/json"
}
Invoke-WebRequest -Uri "http://localhost:8000/api/mobile/especies" -Method GET -Headers $headers | Select-Object -ExpandProperty Content
```

### Con Postman/Insomnia

1. Importa la colección (si existe) o crea peticiones manualmente
2. Base URL: `http://localhost:8000/api/mobile`
3. Endpoints disponibles: Ver `docs/API_MOBILE.md`

## 📱 Configuración de la App Móvil (React Native/Expo)

### 1. Instalar Dependencias

```bash
cd mobile
npm install
```

### 2. Configurar URL de la API

Edita tu archivo de configuración de API (ejemplo: `src/config/api.js`):

```javascript
// Para Android Emulator
export const API_URL = "http://10.0.2.2:8000/api/mobile";

// Para iOS Simulator o dispositivo físico con mismo WiFi
export const API_URL = "http://TU_IP_LOCAL:8000/api/mobile";
// Ejemplo: http://192.168.1.100:8000/api/mobile
```

**Para encontrar tu IP local en Windows:**

```powershell
ipconfig
# Busca "Dirección IPv4" en tu adaptador WiFi/Ethernet
```

### 3. Iniciar la App

```bash
npm start
# o
npx expo start
```

## 🔧 Solución de Problemas

### Error: "could not translate host name"

**Problema:** No puede conectar a Supabase.

**Solución:**
1. Verifica tu conexión a internet
2. Verifica que el `DB_HOST` en `.env` sea correcto
3. Prueba con el puerto directo `5432` en lugar de `6543` (pooler)

### Error: "The bootstrap/cache directory must be present"

**Solución:**
```bash
mkdir -p bootstrap/cache
chmod 777 bootstrap/cache
composer dump-autoload
```

### Error: "Failed to clear cache"

**Solución:**
```bash
# Cambiar en .env:
CACHE_STORE=file  # en lugar de database
SESSION_DRIVER=file  # en lugar de database

php artisan config:clear
```

### Error 500 al hacer peticiones

**Solución:**
1. Revisa los logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```
2. Verifica que las migraciones se ejecutaron:
   ```bash
   php artisan migrate:status
   ```
3. Verifica que los seeders se ejecutaron:
   ```bash
   php artisan tinker
   # Dentro de tinker:
   \App\Models\Especie::count()
   \App\Models\User::where('rol', 'veterinario')->count()
   ```

### La app móvil no puede conectar al backend

**Soluciones:**

1. **Android Emulator:** Usa `http://10.0.2.2:8000`
2. **iOS Simulator:** Usa `http://localhost:8000`
3. **Dispositivo físico:** Usa tu IP local `http://192.168.X.X:8000`
4. **Verifica que el servidor Laravel esté corriendo:** Debería ver "Server running on [http://127.0.0.1:8000]"
5. **Verifica el firewall de Windows:** Permite conexiones en el puerto 8000

## 📚 Documentación Adicional

- **API Completa:** Ver `docs/API_MOBILE.md`
- **Guía Rápida:** Ver `docs/QUICKSTART_MOBILE.md`
- **README Principal:** Ver `README_MOBILE_API.md`

## 🎯 Próximos Pasos

Una vez que todo funcione:

1. ✅ Registra un tutor desde la app móvil
2. ✅ Verifica que puedes ver especies y razas
3. ✅ Registra una mascota
4. ✅ Crea una cita

## 🆘 Soporte

Si tienes problemas:

1. Revisa esta guía completa
2. Consulta los logs de Laravel: `storage/logs/laravel.log`
3. Verifica la configuración del `.env`
4. Asegúrate de que todas las migraciones y seeders se ejecutaron

---

**Última actualización:** 2024-11-10

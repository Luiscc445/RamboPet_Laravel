# 🚀 Instalación de RamboPet (SIN Docker)

Sistema de Gestión Veterinaria con Laravel 11, Filament PHP 3 y Vue.js 3

---

## 📋 Requisitos Previos

- ✅ **PHP 8.2 o superior** (XAMPP, WAMP, Laragon, etc.)
- ✅ **Composer** (https://getcomposer.org/)
- ✅ **Node.js 18+** y npm
- ✅ **MySQL 8.0** (incluido en XAMPP/WAMP)
- ✅ **Git**

---

## 🔧 Instalación Paso a Paso

### 1️⃣ Clonar el repositorio

```bash
cd C:\
mkdir VeterinariaLaravelito
cd VeterinariaLaravelito
git clone <URL_DEL_REPOSITORIO> .
git checkout claude/laravel-filament-rambopet-011CUw7oxVrHvZLy3TjHvSG4
```

---

### 2️⃣ Crear base de datos

1. Abre **PHPMyAdmin**: http://localhost/phpmyadmin
2. Crea una nueva base de datos llamada: `rambopet`
3. Cotejamiento: `utf8mb4_unicode_ci`

---

### 3️⃣ Configurar el proyecto

```bash
# Copiar archivo de configuración
copy .env.example .env

# Instalar dependencias PHP
composer install

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Crear enlace de storage
php artisan storage:link
```

---

### 4️⃣ Instalar Frontend (Vue.js)

```bash
# Instalar dependencias Node
npm install

# Compilar assets
npm run build
```

---

### 5️⃣ Crear usuario administrador

```bash
php artisan tinker
```

Dentro de Tinker, ejecuta:

```php
$user = new App\Models\User();
$user->name = 'Administrador';
$user->email = 'admin@rambopet.com';
$user->password = bcrypt('password123');
$user->rol = 'admin';
$user->activo = true;
$user->save();
exit
```

---

### 6️⃣ Levantar el servidor

```bash
php artisan serve
```

---

## 🌐 Acceso a la Aplicación

### Panel de Administración (Filament)
```
URL: http://localhost:8000/admin
Email: admin@rambopet.com
Password: password123
```

### Frontend Público (Vue.js)
```
URL: http://localhost:8000
```

### PHPMyAdmin
```
URL: http://localhost/phpmyadmin
Usuario: root
Password: (vacío)
```

---

## 📊 Base de Datos

La aplicación creará automáticamente estas tablas:

- ✅ `users` - Usuarios del sistema
- ✅ `tutores` - Dueños de mascotas
- ✅ `especies` y `razas`
- ✅ `mascotas` - Información de mascotas
- ✅ `citas` - Sistema de citas
- ✅ `episodios_clinicos` - Historial médico
- ✅ `productos`, `lotes`, `movimientos_inventario` - Gestión de inventario

---

## 🛠️ Comandos Útiles

### Desarrollo Frontend (Hot Reload)
```bash
npm run dev
```

### Ejecutar Colas (Tareas en segundo plano)
```bash
php artisan queue:work
```

### Comandos de Consola
```bash
# Enviar recordatorios de citas
php artisan citas:enviar-recordatorios

# Marcar citas perdidas
php artisan citas:marcar-perdidas

# Alertas de stock bajo
php artisan inventario:alertas-stock
```

### Limpiar Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Recrear Base de Datos
```bash
php artisan migrate:fresh
```

---

## 🔐 Configuración de .env

Asegúrate de que tu archivo `.env` tenga estos valores:

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rambopet
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
CACHE_STORE=database
```

---

## 📱 Stack Tecnológico

- **Backend:** Laravel 11
- **Panel Admin:** Filament PHP 3.2
- **Frontend:** Vue.js 3 + Vite
- **CSS:** Tailwind CSS 3
- **Base de Datos:** MySQL 8
- **Autenticación API:** Laravel Sanctum

---

## 🆘 Solución de Problemas

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error de base de datos
- Verifica que MySQL esté corriendo
- Verifica las credenciales en `.env`
- Asegúrate de crear la base de datos `rambopet`

### Error de permisos
```bash
# En Windows (PowerShell como Admin)
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T
```

### Limpiar todo y empezar de nuevo
```bash
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan storage:link
npm install
npm run build
```

---

## 📝 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

---

**¡Listo para usar!** 🐾

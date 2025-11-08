# RamboPet - Sistema de Gestión Integral para Clínica Veterinaria

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![Filament](https://img.shields.io/badge/Filament-3.2-orange)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-green)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-blue)

Sistema moderno de gestión veterinaria desarrollado con Laravel, Filament PHP, Vue.js y Tailwind CSS.

## 🚀 Stack Tecnológico

### Backend
- **Laravel 11**: Framework PHP moderno
- **Filament PHP 3.2**: Panel de administración elegante y potente
- **Laravel Sanctum**: Autenticación API segura
- **Laravel Queues**: Procesamiento asíncrono de tareas
- **Spatie Laravel Permission**: Sistema de roles y permisos

### Frontend
- **Vue.js 3**: Framework JavaScript progresivo
- **Vite**: Empaquetador ultrarrápido
- **Tailwind CSS**: Framework CSS utility-first
- **Pinia**: State management para Vue
- **Vue Router**: Enrutamiento SPA

### Base de Datos e Infraestructura
- **MySQL 8**: Base de datos relacional (PHPMyAdmin)
- **PHP 8.2+**: Servidor nativo (XAMPP/WAMP/Laragon)
- **Colas de Laravel**: Sistema de colas con driver database

## 📋 Características Principales

### Panel de Administración (Filament)
- ✅ Gestión completa de tutores (dueños de mascotas)
- ✅ Gestión de mascotas con historial médico
- ✅ Sistema de citas con recordatorios automáticos
- ✅ Gestión de inventario (productos, lotes, movimientos)
- ✅ Control de usuarios y roles
- ✅ Reportes y dashboard analítico

### API REST (Para App Móvil/SPA)
- ✅ Autenticación JWT con Laravel Sanctum
- ✅ CRUD completo de mascotas
- ✅ Gestión de citas (crear, confirmar, cancelar)
- ✅ Consulta de historial clínico
- ✅ Gestión de productos e inventario

### Frontend Público (Vue.js)
- ✅ Portal de tutores
- ✅ Reserva de citas en línea
- ✅ Consulta de historial de mascotas
- ✅ Perfil de usuario

### Tareas Asíncronas
- ✅ Envío automático de recordatorios de citas
- ✅ Alertas de stock bajo
- ✅ Marcado automático de citas perdidas

## 📦 Instalación

### Requisitos Previos
- PHP 8.2 o superior (XAMPP, WAMP, Laragon)
- Composer
- Node.js 18+ y npm
- MySQL 8.0
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd RamboPet_Laravel
```

2. **Crear base de datos**
- Abre PHPMyAdmin: http://localhost/phpmyadmin
- Crea una base de datos llamada: `rambopet`
- Cotejamiento: `utf8mb4_unicode_ci`

3. **Copiar archivo de entorno**
```bash
copy .env.example .env
```

4. **Instalar dependencias PHP**
```bash
composer install
```

5. **Generar clave de aplicación**
```bash
php artisan key:generate
```

6. **Ejecutar migraciones**
```bash
php artisan migrate
```

7. **Crear enlace simbólico de storage**
```bash
php artisan storage:link
```

8. **Instalar dependencias Node.js**
```bash
npm install
```

9. **Compilar assets**
```bash
npm run build
```

10. **Crear usuario administrador**
```bash
php artisan tinker
```

Dentro de Tinker:
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

11. **Levantar el servidor**
```bash
php artisan serve
```

## 🔧 Configuración

### Accesos

- **Aplicación Web**: http://localhost:8000
- **Panel Admin (Filament)**: http://localhost:8000/admin
- **PHPMyAdmin**: http://localhost/phpmyadmin
- **API**: http://localhost:8000/api/v1

### Usuario Administrador por Defecto
```
Email: admin@rambopet.com
Password: password
```

## 🛠️ Desarrollo

### Comandos Útiles

**Ejecutar migrations**
```bash
php artisan migrate
```

**Rollback migrations**
```bash
php artisan migrate:rollback
```

**Refrescar base de datos**
```bash
php artisan migrate:fresh
```

**Compilar assets en modo desarrollo (con hot reload)**
```bash
npm run dev
```

**Ver logs de Laravel**
```bash
tail -f storage/logs/laravel.log
```

**Limpiar cache**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Queue Workers

El sistema utiliza Laravel Queues para procesar tareas en segundo plano.

**Ejecutar el worker manualmente:**
```bash
php artisan queue:work
```

**Ver el estado de las colas:**
```bash
php artisan queue:monitor
```

**Configurar en producción:**
- Usa Supervisor en Linux
- Usa NSSM o Task Scheduler en Windows

### Tareas Programadas

Las tareas programadas se ejecutan automáticamente:

- **9:00 AM**: Envío de recordatorios de citas
- **11:00 PM**: Marcado de citas perdidas
- **8:00 AM**: Alertas de stock bajo

**Ejecutar manualmente:**
```bash
# Enviar recordatorios
php artisan citas:enviar-recordatorios

# Marcar citas perdidas
php artisan citas:marcar-perdidas

# Alertas de stock
php artisan inventario:alertas-stock
```

## 📊 Estructura del Proyecto

```
RamboPet_Laravel/
├── app/
│   ├── Console/Commands/         # Comandos Artisan
│   ├── Filament/Resources/       # Recursos Filament (Admin Panel)
│   ├── Http/
│   │   ├── Controllers/Api/V1/   # Controladores API
│   │   └── Resources/            # API Resources (transformers)
│   ├── Jobs/                     # Jobs de cola
│   ├── Models/                   # Modelos Eloquent
│   └── Providers/                # Service Providers
├── database/
│   ├── migrations/               # Migraciones
│   └── seeders/                  # Seeders
├── resources/
│   ├── css/                      # Estilos CSS
│   ├── js/                       # Aplicación Vue.js
│   │   ├── components/
│   │   ├── router/
│   │   └── views/
│   └── views/                    # Vistas Blade
├── routes/
│   ├── api.php                   # Rutas API
│   ├── console.php               # Rutas de consola
│   └── web.php                   # Rutas web
└── README.md
```

## 🗃️ Modelos de Datos Principales

- **User**: Usuarios del sistema (admin, veterinario, recepcionista, cliente)
- **Tutor**: Dueños de mascotas
- **Mascota**: Información de las mascotas
- **Especie**: Especies de animales
- **Raza**: Razas por especie
- **Cita**: Citas médicas
- **EpisodioClinico**: Historial clínico
- **Producto**: Productos e insumos
- **Lote**: Lotes de productos
- **MovimientoInventario**: Movimientos de stock

## 🔐 Seguridad

- Autenticación JWT con Laravel Sanctum
- Roles y permisos con Spatie Laravel Permission
- Validación de datos en todos los endpoints
- Protección CSRF en formularios
- Encriptación de contraseñas con bcrypt
- Rate limiting en API

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Tests con coverage
php artisan test --coverage
```

## 📝 API Endpoints Principales

### Autenticación
```
POST /api/v1/login         # Login
POST /api/v1/register      # Registro
POST /api/v1/logout        # Logout
GET  /api/v1/user          # Usuario autenticado
```

### Mascotas
```
GET    /api/v1/mascotas              # Listar mascotas
POST   /api/v1/mascotas              # Crear mascota
GET    /api/v1/mascotas/{id}         # Ver mascota
PUT    /api/v1/mascotas/{id}         # Actualizar mascota
DELETE /api/v1/mascotas/{id}         # Eliminar mascota
GET    /api/v1/mascotas/{id}/historial  # Historial clínico
```

### Citas
```
GET    /api/v1/citas                 # Listar citas
POST   /api/v1/citas                 # Crear cita
GET    /api/v1/citas/{id}            # Ver cita
PUT    /api/v1/citas/{id}            # Actualizar cita
DELETE /api/v1/citas/{id}            # Eliminar cita
GET    /api/v1/citas/proximas        # Citas próximas
POST   /api/v1/citas/{id}/confirmar  # Confirmar cita
POST   /api/v1/citas/{id}/cancelar   # Cancelar cita
```

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

## 👥 Equipo

Desarrollado por el equipo de RamboPet

## 📞 Soporte

Para reportar bugs o solicitar features, por favor abre un issue en GitHub.

---

**RamboPet** - Sistema de Gestión Veterinaria del Siglo XXI 🐾

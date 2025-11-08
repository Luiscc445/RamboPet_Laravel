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
- **MySQL 8**: Base de datos relacional
- **Redis**: Cache y colas
- **Docker & Docker Compose**: Contenedorización
- **Nginx**: Servidor web
- **PHP-FPM**: Procesador PHP

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
- Docker y Docker Compose instalados
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd RamboPet_Laravel
```

2. **Copiar archivo de entorno**
```bash
cp .env.example .env
```

3. **Levantar los contenedores Docker**
```bash
docker-compose up -d
```

4. **Instalar dependencias PHP**
```bash
docker-compose exec app composer install
```

5. **Generar clave de aplicación**
```bash
docker-compose exec app php artisan key:generate
```

6. **Ejecutar migraciones**
```bash
docker-compose exec app php artisan migrate --seed
```

7. **Instalar dependencias Node.js**
```bash
docker-compose exec app npm install
```

8. **Compilar assets**
```bash
docker-compose exec app npm run build
```

9. **Crear enlace simbólico de storage**
```bash
docker-compose exec app php artisan storage:link
```

## 🔧 Configuración

### Accesos

- **Aplicación Web**: http://localhost:8080
- **Panel Admin (Filament)**: http://localhost:8080/admin
- **PHPMyAdmin**: http://localhost:8081
- **API**: http://localhost:8080/api/v1

### Usuario Administrador por Defecto
```
Email: admin@rambopet.com
Password: password
```

## 🛠️ Desarrollo

### Comandos Útiles

**Ejecutar migrations**
```bash
docker-compose exec app php artisan migrate
```

**Rollback migrations**
```bash
docker-compose exec app php artisan migrate:rollback
```

**Refrescar base de datos con seeders**
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

**Compilar assets en modo desarrollo**
```bash
docker-compose exec app npm run dev
```

**Ver logs de Laravel**
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

**Acceder al contenedor de la aplicación**
```bash
docker-compose exec app bash
```

### Queue Workers

El sistema utiliza Laravel Queues para procesar tareas en segundo plano. Los workers están configurados para ejecutarse automáticamente en el contenedor `queue`.

**Ver el estado de las colas:**
```bash
docker-compose exec app php artisan queue:monitor
```

**Reiniciar workers:**
```bash
docker-compose restart queue
```

### Tareas Programadas

Las tareas programadas se ejecutan automáticamente:

- **9:00 AM**: Envío de recordatorios de citas
- **11:00 PM**: Marcado de citas perdidas
- **8:00 AM**: Alertas de stock bajo

**Ejecutar manualmente:**
```bash
# Enviar recordatorios
docker-compose exec app php artisan citas:enviar-recordatorios

# Marcar citas perdidas
docker-compose exec app php artisan citas:marcar-perdidas

# Alertas de stock
docker-compose exec app php artisan inventario:alertas-stock
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
├── docker/                       # Configuraciones Docker
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
├── docker-compose.yml            # Configuración Docker Compose
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
docker-compose exec app php artisan test

# Tests con coverage
docker-compose exec app php artisan test --coverage
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

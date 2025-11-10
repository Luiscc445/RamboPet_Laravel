# 📱 RamboPet - API Mobile

API REST completa para la aplicación móvil de RamboPet, un sistema de gestión veterinaria.

## ✨ Nuevas Funcionalidades Implementadas

### Endpoints Agregados

**Catálogos:**
- ✅ `GET /api/mobile/especies` - Listar especies disponibles
- ✅ `GET /api/mobile/razas` - Listar razas (con filtro por especie)

**Gestión de Mascotas:**
- ✅ `PUT /api/mobile/mascotas/{id}` - Actualizar información de mascota
- ✅ `DELETE /api/mobile/mascotas/{id}` - Eliminar mascota (con validación de citas)

**Perfil de Tutor:**
- ✅ `PUT /api/mobile/tutor/profile` - Actualizar perfil del tutor

**Citas:**
- ✅ `GET /api/mobile/citas/{id}` - Ver detalle de una cita específica

### Mejoras Implementadas

- ✅ Tipos de consulta unificados (mobile y v1 compatibles)
- ✅ Validación de propiedad en todas las operaciones
- ✅ Validación de citas pendientes antes de eliminar mascotas
- ✅ Gestión automática de imágenes (upload y eliminación)
- ✅ Soporte para filtrado de razas por especie
- ✅ Auto-creación de perfil de tutor si no existe
- ✅ Sincronización entre User y Tutor

## 🚀 Inicio Rápido

### 1. Configurar Backend

```bash
# Instalar dependencias
composer install

# Configurar archivo .env
cp .env.example .env
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Cargar datos iniciales
php artisan db:seed --class=EspecieRazaSeeder
php artisan db:seed --class=UserSeeder

# Crear storage link (para imágenes)
php artisan storage:link

# Iniciar servidor
php artisan serve
```

### 2. Crear Usuario Veterinario

```bash
php artisan tinker
```

Ejecutar en tinker:
```php
\App\Models\User::create([
    'name' => 'Dr. Carlos Méndez',
    'email' => 'vet@rambopet.cl',
    'password' => bcrypt('password123'),
    'rol' => 'veterinario',
    'telefono' => '+56922334455',
    'activo' => true
]);
```

### 3. Probar la API

```bash
# Registro de tutor
curl -X POST http://localhost:8000/api/mobile/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Juan Pérez",
    "email": "juan@test.com",
    "password": "password123",
    "password_confirmation": "password123",
    "telefono": "+56912345678",
    "rut": "12345678-9"
  }'
```

## 📚 Documentación

- **[API Mobile Completa](./docs/API_MOBILE.md)** - Documentación detallada de todos los endpoints
- **[Quick Start Guide](./docs/QUICKSTART_MOBILE.md)** - Guía rápida de integración con ejemplos de código

## 🔑 Endpoints Disponibles

### Autenticación (Público)
- `POST /api/mobile/register` - Registro de nuevo tutor
- `POST /api/mobile/login` - Inicio de sesión

### Autenticación (Protegido)
- `POST /api/mobile/logout` - Cerrar sesión
- `GET /api/mobile/me` - Obtener usuario autenticado

### Perfil del Tutor
- `GET /api/mobile/tutor/profile` - Obtener perfil
- `PUT /api/mobile/tutor/profile` - Actualizar perfil

### Catálogos
- `GET /api/mobile/especies` - Listar especies
- `GET /api/mobile/razas` - Listar razas (filtrable por especie_id)

### Mascotas
- `GET /api/mobile/mascotas` - Listar mascotas del tutor
- `POST /api/mobile/mascotas` - Registrar nueva mascota
- `PUT /api/mobile/mascotas/{id}` - Actualizar mascota
- `DELETE /api/mobile/mascotas/{id}` - Eliminar mascota

### Veterinarios
- `GET /api/mobile/veterinarios` - Listar veterinarios activos

### Citas
- `GET /api/mobile/citas` - Listar citas del tutor
- `GET /api/mobile/citas/{id}` - Ver detalle de cita
- `POST /api/mobile/citas` - Crear nueva cita
- `POST /api/mobile/citas/{id}/cancel` - Cancelar cita

## 🔐 Autenticación

Todas las rutas protegidas requieren el header:
```
Authorization: Bearer {token}
```

El token se obtiene al hacer login o register.

## 📊 Tipos de Consulta Soportados

- `consulta_general` - Consulta médica general
- `vacunacion` - Vacunación
- `cirugia` - Procedimiento quirúrgico
- `urgencia` - Atención urgente
- `emergencia` - Atención de emergencia
- `control` - Control médico
- `peluqueria` - Servicio de peluquería (solo mobile)

## 🛡️ Validaciones y Seguridad

- ✅ Autenticación con Laravel Sanctum
- ✅ Solo usuarios con rol 'cliente' pueden acceder a mobile
- ✅ Validación de propiedad (tutor solo ve sus mascotas/citas)
- ✅ No se pueden eliminar mascotas con citas pendientes
- ✅ Las citas deben ser en fechas futuras
- ✅ Imágenes limitadas a 2MB
- ✅ Validación de relaciones (especie-raza, mascota-tutor)

## 🎯 Flujo Típico de Usuario

1. **Registro/Login** → Obtener token
2. **Obtener Especies** → Mostrar en formulario
3. **Obtener Razas** → Filtrar por especie seleccionada
4. **Registrar Mascota** → Con datos + foto opcional
5. **Ver Veterinarios** → Para agendar cita
6. **Crear Cita** → Seleccionar mascota, veterinario, fecha
7. **Gestionar Citas** → Ver, detallar, cancelar

## 🗂️ Estructura de Datos

### User (Tutor)
```json
{
  "id": 1,
  "name": "Juan Pérez",
  "email": "juan@test.com",
  "rol": "cliente",
  "telefono": "+56912345678",
  "rut": "12345678-9",
  "direccion": "Av. Providencia 123",
  "activo": true
}
```

### Mascota
```json
{
  "id": 1,
  "nombre": "Max",
  "especie_id": 1,
  "raza_id": 1,
  "fecha_nacimiento": "2020-05-15",
  "sexo": "macho",
  "color": "Dorado",
  "peso": 25.5,
  "foto": "mascotas/abc123.jpg",
  "esterilizado": false,
  "alergias": null,
  "condiciones_medicas": null
}
```

### Cita
```json
{
  "id": 1,
  "mascota_id": 1,
  "veterinario_id": 5,
  "tipo_consulta": "consulta_general",
  "fecha_hora": "2024-11-15 10:00:00",
  "estado": "pendiente",
  "motivo": "Control de rutina",
  "confirmada": false
}
```

## 📝 Migraciones Nuevas

- `2024_11_10_000002_add_additional_tipo_consulta_to_citas_table.php`
  - Agrega tipos: `urgencia`, `peluqueria` al enum de tipo_consulta

## 🧪 Testing

### Probar con cURL

```bash
# 1. Registrar
TOKEN=$(curl -s -X POST http://localhost:8000/api/mobile/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"12345678","password_confirmation":"12345678","telefono":"+56912345678","rut":"11111111-1"}' \
  | jq -r '.token')

# 2. Listar especies
curl -X GET http://localhost:8000/api/mobile/especies \
  -H "Authorization: Bearer $TOKEN"

# 3. Listar mascotas
curl -X GET http://localhost:8000/api/mobile/mascotas \
  -H "Authorization: Bearer $TOKEN"
```

### Probar con Postman

1. Importar colección desde `docs/postman_collection.json` (si existe)
2. Configurar variable de entorno `BASE_URL` = `http://localhost:8000`
3. Ejecutar flujo completo de endpoints

## 🔧 Configuración Adicional

### CORS (para web/mobile)

En `config/cors.php`:
```php
'paths' => ['api/*'],
'allowed_origins' => ['*'], // Configurar según necesidad
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Sanctum

En `config/sanctum.php`:
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,127.0.0.1')),
```

### Storage

Asegurar que `storage/app/public` esté linkeado:
```bash
php artisan storage:link
```

Las imágenes se guardan en `storage/app/public/mascotas/`
Y son accesibles via: `http://localhost:8000/storage/mascotas/imagen.jpg`

## 🐛 Troubleshooting

**Error: "Unauthenticated"**
- Verificar que el token esté en el header `Authorization: Bearer {token}`
- Verificar que el token no haya sido revocado (logout)

**Error: "No autorizado" (403)**
- El usuario está intentando acceder a recursos que no le pertenecen
- Verificar que la mascota pertenezca al tutor autenticado

**Error de validación (422)**
- Revisar los campos requeridos en la documentación
- Verificar que los IDs existan (especie_id, raza_id, etc.)

**Imágenes no se cargan**
- Ejecutar `php artisan storage:link`
- Verificar permisos de `storage/app/public`

## 📦 Requisitos del Sistema

- PHP >= 8.1
- Laravel 10.x
- MySQL/MariaDB
- Composer
- GD Library (para imágenes)

## 🚀 Próximos Pasos

- [ ] Implementar notificaciones push
- [ ] Agregar paginación a listados
- [ ] Sistema de recuperación de contraseña
- [ ] Verificación de email
- [ ] Historial médico detallado
- [ ] Sistema de archivos/documentos
- [ ] Chat con veterinario
- [ ] Pasarela de pagos

## 🤝 Contribución

Para agregar nuevos endpoints:
1. Agregar método en `app/Http/Controllers/API/MobileController.php`
2. Registrar ruta en `routes/api.php`
3. Documentar en `docs/API_MOBILE.md`
4. Agregar ejemplo en `docs/QUICKSTART_MOBILE.md`

## 📄 Licencia

Propietario - RamboPet

---

**Desarrollado con ❤️ para RamboPet**

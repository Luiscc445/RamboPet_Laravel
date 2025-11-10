# 🚀 Guía Rápida: Configurar Supabase PostgreSQL

Esta guía te ayudará a migrar de MySQL a Supabase PostgreSQL en 5 minutos.

---

## ✅ Paso 1: Verificar Extensión PostgreSQL en PHP

Laravel necesita la extensión `pdo_pgsql` para conectarse a PostgreSQL.

**Verificar:**
```bash
php -m | grep pgsql
```

**Si NO aparece `pdo_pgsql`, instálala:**

### Windows (XAMPP):
1. Abre `C:\xampp\php\php.ini` (o donde tengas PHP instalado)
2. Busca estas líneas y **DESCOMÉNTALAS** (elimina el `;`):
   ```ini
   ;extension=pdo_pgsql
   ;extension=pgsql
   ```
   Quedarían así:
   ```ini
   extension=pdo_pgsql
   extension=pgsql
   ```
3. Guarda y cierra
4. Reinicia Apache si está corriendo

### Linux:
```bash
sudo apt-get install php-pgsql
sudo systemctl restart apache2  # o tu servidor web
```

### Mac:
```bash
brew install php
# o si usas MAMP, la extensión ya viene incluida
```

---

## ✅ Paso 2: Actualizar archivo .env

**Copia el `.env.example` actualizado:**
```bash
cp .env.example .env
```

O **edita tu `.env` existente** y reemplaza la sección de base de datos:

```env
# Reemplaza estas líneas MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=rambopet
# DB_USERNAME=root
# DB_PASSWORD=

# Por estas de Supabase PostgreSQL:
DB_CONNECTION=pgsql
DB_HOST=aws-1-us-east-2.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.dcahbgpeupxcqsybffhq
DB_PASSWORD=Haaland890//

# API Keys de Supabase (opcional, para funciones avanzadas)
SUPABASE_URL=https://dcahbgpeupxcqsybffhq.supabase.co
SUPABASE_ANON_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRjYWhiZ3BldXB4Y3FzeWJmZmhxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI3NjAxMjMsImV4cCI6MjA3ODMzNjEyM30.lJ0NeafdTABeTr5eXilz2xlsY46JtFeTVXPcI9Og4xY
SUPABASE_SERVICE_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRjYWhiZ3BldXB4Y3FzeWJmZmhxIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc2Mjc2MDEyMywiZXhwIjoyMDc4MzM2MTIzfQ.TNWgo2mCGbGj83Xn1c9jCAFWOatXPM6FgOpiqlct3RY
```

---

## ✅ Paso 3: Probar Conexión

```bash
php artisan db:show
```

**Deberías ver:**
```
PostgreSQL ........... 16.x
Database ............. postgres
Host ................. aws-1-us-east-2.pooler.supabase.com
Port ................. 6543
Username ............. postgres.dcahbgpeupxcqsybffhq
```

---

## ✅ Paso 4: Ejecutar Migraciones

### Opción A: Limpiar y crear todo de nuevo (RECOMENDADO)
```bash
php artisan migrate:fresh --seed
```
Esto:
- ✅ Borra todas las tablas
- ✅ Ejecuta todas las migraciones
- ✅ Crea usuarios y datos de prueba

### Opción B: Solo ejecutar nuevas migraciones (si ya tienes datos)
```bash
php artisan migrate
```

---

## ✅ Paso 5: Iniciar Servidor

```bash
php artisan serve --port=8000
```

Ahora puedes acceder a:
- **API:** http://localhost:8000/api
- **Panel Admin:** http://localhost:8000/admin
  - Email: `admin@rambopet.cl`
  - Password: `admin123`

---

## 🔧 Solución de Problemas

### Error: "could not find driver"
**Causa:** La extensión `pdo_pgsql` no está habilitada.
**Solución:** Repite el Paso 1.

### Error: "Connection refused"
**Causa:** Credenciales incorrectas o firewall.
**Solución:**
1. Verifica que copiaste bien la password: `Haaland890//`
2. Verifica que tu firewall permita conexiones al puerto 6543

### Error: "SQLSTATE[08006]"
**Causa:** No se puede conectar a Supabase.
**Solución:**
1. Verifica tu conexión a internet
2. Prueba ping: `ping aws-1-us-east-2.pooler.supabase.com`
3. Verifica que las credenciales en `.env` sean correctas

### Error: "relation does not exist"
**Causa:** Las tablas no existen aún.
**Solución:** Ejecuta las migraciones: `php artisan migrate:fresh --seed`

---

## 📊 Verificar Datos en Supabase

1. Ve al dashboard: https://supabase.com/dashboard/project/dcahbgpeupxcqsybffhq
2. Haz clic en "Table Editor" en el menú lateral
3. Verás todas las tablas creadas por Laravel

---

## 🎯 Diferencias MySQL vs PostgreSQL

Laravel se encarga de casi todo automáticamente, pero ten en cuenta:

| MySQL | PostgreSQL |
|-------|-----------|
| `AUTO_INCREMENT` | `SERIAL` o `IDENTITY` |
| Case-insensitive por defecto | Case-sensitive |
| `LIMIT 10` | `LIMIT 10` (igual) |
| `VARCHAR(255)` | `VARCHAR(255)` (igual) |
| Funciones de fecha diferentes | `NOW()`, `CURRENT_DATE` |

**Laravel maneja todo esto automáticamente con Eloquent. No necesitas cambiar tu código.**

---

## 📚 Comandos Útiles

```bash
# Ver configuración de base de datos
php artisan db:show

# Ver todas las tablas
php artisan db:table --database=pgsql

# Ejecutar query SQL directamente
php artisan tinker
>>> DB::select('SELECT * FROM users LIMIT 1');

# Limpiar caché de configuración
php artisan config:clear
php artisan cache:clear
```

---

## ✨ Ventajas de Supabase

- ✅ **PostgreSQL en la nube** - No necesitas instalar ni configurar
- ✅ **Backup automático** - Tus datos están seguros
- ✅ **Escalable** - Crece con tu proyecto
- ✅ **Panel de administración** - Visualiza y edita datos fácilmente
- ✅ **API REST automática** - Cada tabla tiene endpoints REST
- ✅ **Auth integrado** - Sistema de autenticación incluido
- ✅ **Storage** - Almacenamiento de archivos incluido
- ✅ **Gratis hasta 500MB** - Perfecto para desarrollo

---

## 🔐 Seguridad

**IMPORTANTE:** El archivo `SUPABASE_CREDENTIALS.md` contiene información sensible.

- ✅ Ya está en `.gitignore` - No se subirá a GitHub
- ⚠️ NO compartas las credenciales públicamente
- 🔒 La **Service Role Key** tiene acceso total - Nunca la expongas en frontend

---

## 📞 Soporte

Si tienes problemas:
1. Lee la sección "Solución de Problemas" arriba
2. Verifica los logs: `storage/logs/laravel.log`
3. Revisa la documentación: [SUPABASE_CREDENTIALS.md](SUPABASE_CREDENTIALS.md)

---

**¡Listo! Ahora estás usando Supabase PostgreSQL 🎉**

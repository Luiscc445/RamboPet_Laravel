# Configuración OPcache para Windows - RamboPet

OPcache es **CRÍTICO** para rendimiento en producción. Puede mejorar el rendimiento hasta **3-5x** sin cambios de código.

---

## ¿Qué es OPcache?

OPcache es un sistema de caché de **bytecode** de PHP. Compila el código PHP una vez y lo almacena en memoria, evitando recompilaciones en cada request.

**Beneficios:**
- ⚡ 3-5x más rápido
- 💾 Reduce uso de CPU
- 🚀 Ideal para producción

---

## 🔍 Verificar si OPcache está habilitado

Ejecuta en terminal:

```bash
php -i | findstr opcache
```

Si ves `opcache.enable => On`, ya está habilitado. Si no, continúa con la configuración.

---

## ⚙️ Configuración de OPcache para Windows

### **Paso 1: Localizar php.ini**

Ejecuta:

```bash
php --ini
```

Verás algo como:
```
Loaded Configuration File: C:\xampp\php\php.ini
```

### **Paso 2: Editar php.ini**

Abre `php.ini` con un editor de texto (como Notepad++ o VSCode) **como Administrador**.

Busca la sección `[opcache]` (usa Ctrl+F).

### **Paso 3: Configuración RECOMENDADA**

Reemplaza o agrega estas líneas:

```ini
[opcache]
; Habilitar OPcache
opcache.enable=1
opcache.enable_cli=1

; Memoria asignada a OPcache (en MB)
opcache.memory_consumption=256

; Memoria para strings internos
opcache.interned_strings_buffer=16

; Número máximo de archivos a cachear
opcache.max_accelerated_files=20000

; Validación de timestamps
; DESARROLLO: 1 (valida cambios en archivos)
; PRODUCCIÓN: 0 (no valida, máximo rendimiento)
opcache.validate_timestamps=1
opcache.revalidate_freq=2

; Optimizaciones adicionales
opcache.fast_shutdown=1
opcache.save_comments=1
opcache.enable_file_override=0

; JIT (Just-In-Time Compilation) - PHP 8.0+
; Mejora aún más el rendimiento
opcache.jit_buffer_size=256M
opcache.jit=1255
```

### **Paso 4: Configuración para PRODUCCIÓN**

Cuando subas a producción, cambia estas líneas:

```ini
; PRODUCCIÓN: Máximo rendimiento
opcache.validate_timestamps=0
opcache.revalidate_freq=0
```

**IMPORTANTE:** Con `validate_timestamps=0`, los cambios en código NO se reflejarán automáticamente. Debes reiniciar PHP después de cada deploy.

---

## 🔄 Reiniciar PHP/Servidor

### **XAMPP:**

```bash
# Detener
C:\xampp\xampp_stop.exe

# Iniciar
C:\xampp\xampp_start.exe
```

O usa el panel de control de XAMPP.

### **Laragon:**

Haz clic derecho en el ícono de Laragon → Stop All → Start All

### **PHP Built-in Server:**

Cierra la terminal donde ejecutaste `php artisan serve` y vuelve a ejecutarlo.

---

## ✅ Verificar que OPcache funciona

Después de reiniciar, ejecuta:

```bash
php -r "var_dump(opcache_get_status());"
```

Deberías ver un array grande con información de OPcache.

También puedes verificar en tu aplicación:

```php
// routes/web.php o donde sea
Route::get('/opcache-status', function() {
    if (!function_exists('opcache_get_status')) {
        return 'OPcache NO disponible';
    }

    $status = opcache_get_status();
    return response()->json([
        'enabled' => $status !== false,
        'cache_full' => $status['cache_full'] ?? null,
        'num_cached_scripts' => $status['opcache_statistics']['num_cached_scripts'] ?? 0,
        'memory_usage' => $status['memory_usage'] ?? [],
    ]);
});
```

Visita: `http://localhost:8000/opcache-status`

---

## 🔧 Comandos útiles

### Limpiar cache de OPcache

```bash
php -r "opcache_reset(); echo 'OPcache cleared';"
```

### Ver estadísticas

```bash
php -r "print_r(opcache_get_status());"
```

---

## 📊 Benchmarks Esperados

### Sin OPcache:
- Tiempo de respuesta: 200-500ms
- Requests/seg: 50-100

### Con OPcache:
- Tiempo de respuesta: 50-150ms ⚡
- Requests/seg: 150-300 🚀

### Con OPcache + Cache Laravel + Optimizaciones:
- Tiempo de respuesta: < 50ms ⚡⚡
- Requests/seg: 300-500 🚀🚀

---

## 🚨 Problemas Comunes

### Error: "opcache.enable=1 but it's disabled"

**Solución:** Asegúrate de editar el php.ini correcto:

```bash
php --ini
```

Edita el archivo que aparece en "Loaded Configuration File".

### Error: "No se reflejan los cambios en código"

**Causa:** `opcache.validate_timestamps=0` en producción.

**Solución:**

```bash
# Opción 1: Reiniciar servidor
php artisan serve

# Opción 2: Limpiar OPcache
php -r "opcache_reset();"
```

### Error: "Warning: opcache.jit not supported"

**Causa:** PHP < 8.0

**Solución:** Elimina o comenta las líneas `opcache.jit*` en php.ini.

---

## 💡 Recomendaciones

### Desarrollo (Local):
```ini
opcache.enable=1
opcache.validate_timestamps=1
opcache.revalidate_freq=2
```

### Producción:
```ini
opcache.enable=1
opcache.validate_timestamps=0
opcache.revalidate_freq=0
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
```

### Testing/Staging:
```ini
opcache.enable=1
opcache.validate_timestamps=1
opcache.revalidate_freq=0
```

---

## 🔗 Recursos

- [OPcache Documentation](https://www.php.net/manual/en/book.opcache.php)
- [Laravel Performance](https://laravel.com/docs/11.x/deployment#optimization)
- [PHP OPcache Best Practices](https://tideways.com/profiler/blog/fine-tune-your-opcache-configuration-to-avoid-caching-suprises)

---

## 📝 Checklist

- [ ] Localizar php.ini correcto
- [ ] Agregar configuración OPcache
- [ ] Reiniciar servidor PHP
- [ ] Verificar con `php -r "opcache_get_status();"`
- [ ] Probar la aplicación
- [ ] Medir mejora de rendimiento

---

**Creado:** 2025-11-10
**Laravel:** 11.46
**PHP:** 8.2+
**Windows Compatible:** ✅

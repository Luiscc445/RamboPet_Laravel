# 🔧 Solución de Problemas - RamboPet App Móvil

## ❌ Problema: "La app solo muestra el diseño pero no funciona"

### ✅ Paso 1: Verificar que el Backend está Corriendo

```powershell
# En PowerShell, ejecuta:
curl http://localhost:8000/api/mobile/especies

# Deberías ver un error 401 (Unauthenticated) - ESO ES BUENO
# Significa que el backend está corriendo pero necesitas autenticación
```

Si ves `Connection refused` o `Cannot connect`, el servidor Laravel NO está corriendo.

**Solución:** Inicia el servidor:
```powershell
cd C:\VeterinariaLaravelito
php artisan serve
```

---

### ✅ Paso 2: Verificar que el Usuario de Prueba Existe

```powershell
cd C:\VeterinariaLaravelito
php artisan tinker
```

Dentro de tinker, ejecuta:
```php
\App\Models\User::where('email', 'cliente@rambopet.cl')->first()
```

**Si devuelve `null`** (el usuario NO existe):
```php
\App\Models\User::create([
    'name' => 'Pedro López',
    'email' => 'cliente@rambopet.cl',
    'password' => bcrypt('cliente123'),
    'rol' => 'cliente',
    'telefono' => '+56965432109',
    'rut' => '55667788-9',
    'direccion' => 'Santiago Centro',
    'activo' => true
]);
exit
```

**Si devuelve datos del usuario**, está bien. Escribe `exit` y continúa.

---

### ✅ Paso 3: Probar el Login Manualmente con PowerShell

```powershell
$body = @{
    email = "cliente@rambopet.cl"
    password = "cliente123"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "http://localhost:8000/api/mobile/login" -Method POST -Body $body -ContentType "application/json"
$response.Content
```

**Respuesta exitosa debe mostrar:**
```json
{
  "message": "Inicio de sesión exitoso",
  "user": { ... },
  "token": "1|xxxxx..."
}
```

**Si ves error 401 "Invalid credentials":**
- El usuario existe pero la contraseña no coincide
- Resetea la contraseña:
```powershell
php artisan tinker
```
```php
$user = \App\Models\User::where('email', 'cliente@rambopet.cl')->first();
$user->password = bcrypt('cliente123');
$user->save();
exit
```

**Si ves error 422 "Validation failed":**
- Verifica que el `rol` del usuario sea 'cliente'
```powershell
php artisan tinker
```
```php
$user = \App\Models\User::where('email', 'cliente@rambopet.cl')->first();
$user->rol = 'cliente';
$user->activo = true;
$user->save();
exit
```

---

### ✅ Paso 4: Verificar CORS en el Navegador

1. Abre la app en el navegador (`http://localhost:8081`)
2. Presiona **F12** para abrir DevTools
3. Ve a la pestaña **Console**
4. Intenta hacer login

**Si ves error de CORS:**
```
Access to XMLHttpRequest at 'http://localhost:8000/api/mobile/login'
from origin 'http://localhost:8081' has been blocked by CORS policy
```

**Solución:** Verificar que `/config/cors.php` tenga:
```php
'allowed_origins' => ['*'],
'supports_credentials' => true,
```

Luego limpia caché:
```powershell
php artisan config:clear
php artisan cache:clear
```

---

### ✅ Paso 5: Verificar la URL de la API en la App

Edita: `C:\VeterinariaLaravelito\mobile\src\utils\constants.js`

Verifica que la línea 17 diga:
```javascript
export const API_BASE_URL = 'http://localhost:8000/api/mobile';
```

Si cambiaste algo, guarda y recarga la app (Ctrl+R en el navegador).

---

### ✅ Paso 6: Ver Errores en la Consola del Navegador

1. Abre DevTools (F12)
2. Ve a la pestaña **Console**
3. Intenta hacer login o registrarte
4. Revisa los errores que aparezcan

**Errores comunes:**

**"Network Error"**
- El backend no está corriendo
- Ejecuta: `php artisan serve`

**"Request failed with status code 500"**
- Error en el servidor Laravel
- Revisa logs: `C:\VeterinariaLaravelito\storage\logs\laravel.log`

**"Request failed with status code 422"**
- Error de validación
- Lee el mensaje de error en la consola

**"Request failed with status code 401"**
- Credenciales incorrectas
- Verifica email y password

---

### ✅ Paso 7: Ver Peticiones HTTP en DevTools

1. Abre DevTools (F12)
2. Ve a la pestaña **Network** (Red)
3. Intenta hacer login
4. Haz clic en la petición `login` que aparece
5. Ve a la pestaña **Response**

Esto te mostrará exactamente qué está respondiendo el servidor.

---

## 🧪 Prueba Rápida de la API

Crea un archivo `test-api.html` y ábrelo en el navegador:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Test RamboPet API</title>
</head>
<body>
    <h1>Test RamboPet API</h1>
    <button onclick="testLogin()">Test Login</button>
    <pre id="result"></pre>

    <script>
        async function testLogin() {
            const result = document.getElementById('result');
            result.textContent = 'Probando...';

            try {
                const response = await fetch('http://localhost:8000/api/mobile/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: 'cliente@rambopet.cl',
                        password: 'cliente123'
                    })
                });

                const data = await response.json();
                result.textContent = JSON.stringify(data, null, 2);

                if (response.ok) {
                    alert('✅ LOGIN EXITOSO! La API funciona correctamente.');
                } else {
                    alert('❌ Error: ' + (data.message || 'Error desconocido'));
                }
            } catch (error) {
                result.textContent = 'ERROR: ' + error.message;
                alert('❌ No se puede conectar al backend. ¿Está corriendo php artisan serve?');
            }
        }
    </script>
</body>
</html>
```

Si este test funciona, el problema está en la app React Native, no en el backend.

---

## 📝 Checklist Completo

- [ ] Backend Laravel corriendo en `http://localhost:8000`
- [ ] Usuario `cliente@rambopet.cl` existe con password `cliente123`
- [ ] Usuario tiene rol `cliente` y está activo
- [ ] CORS configurado correctamente
- [ ] App móvil apunta a `http://localhost:8000/api/mobile`
- [ ] No hay errores de CORS en la consola del navegador
- [ ] Login manual con PowerShell funciona
- [ ] Test HTML funciona

---

## 🆘 Si Nada Funciona

1. **Resetea la Base de Datos:**
```powershell
php artisan migrate:fresh --seed
```

2. **Limpia Todo:**
```powershell
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

3. **Reinicia el Servidor:**
```powershell
# Ctrl+C para detener
php artisan serve
```

4. **Reinicia la App:**
```powershell
# En el navegador, presiona Ctrl+Shift+R (hard reload)
```

---

**Última actualización:** 2024-11-10

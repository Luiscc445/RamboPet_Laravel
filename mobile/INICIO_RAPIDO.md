# 🚀 Iniciar RamboPet - Guía Rápida

## ✅ Todo ya está configurado y en GitHub

La configuración de la API ya está lista para funcionar con Expo Web.

---

## 📋 Pasos para Iniciar (Windows PowerShell)

### 1️⃣ Iniciar el Servidor Laravel

Abre una terminal PowerShell y ejecuta:

```powershell
cd C:\VeterinariaLaravelito
php artisan serve
```

Deberías ver: `INFO  Server running on [http://127.0.0.1:8000]`

**Deja esta terminal abierta** - el servidor debe quedar corriendo.

---

### 2️⃣ Traer Cambios de GitHub (App Móvil)

Abre **otra terminal PowerShell** y ejecuta:

```powershell
cd C:\VeterinariaLaravelito\mobile
git pull origin claude/tutor-registration-flow-011CUznuM8pFXrjhHBpokK41 --no-edit
```

---

### 3️⃣ Iniciar la App con Expo Web

En la misma terminal del móvil, ejecuta:

```powershell
npm run web
```

Esto abrirá automáticamente tu navegador en `http://localhost:8081` (o el puerto que asigne Expo).

---

## 🎯 ¡A Probar!

Una vez que ambos estén corriendo:

1. **Regístrate** como nuevo tutor
2. **Ve a Mascotas** → deberías ver las especies (Perro, Gato, etc.)
3. **Registra una mascota** con foto
4. **Agenda una cita** seleccionando veterinario

---

## 🔧 Configuración (ya está lista)

- **API Backend:** `http://localhost:8000/api/mobile` ✅
- **Tipos de consulta soportados:**
  - Consulta General
  - Vacunación
  - Cirugía
  - Urgencia
  - Emergencia
  - Control
  - Peluquería

---

## ❌ Si algo falla

**Error: "Cannot connect to backend"**
- Verifica que el servidor Laravel esté corriendo (paso 1)
- Debería estar en http://localhost:8000

**Error al hacer pull**
- Si dice "merge conflict", ejecuta: `git merge --abort`
- Luego intenta el pull nuevamente

**La app no carga**
- Cierra y vuelve a ejecutar `npm run web`
- Verifica que el puerto 8081 no esté ocupado

---

## 📱 Modo Desarrollo

Si quieres probar en Android/iOS emulador:

```powershell
# Android Emulator
npm start
# Luego presiona 'a'

# iOS Simulator (solo Mac)
npm start
# Luego presiona 'i'
```

Para Android emulador, la API usa automáticamente `http://10.0.2.2:8000/api/mobile`

---

**Última actualización:** 2024-11-10
**Branch:** claude/tutor-registration-flow-011CUznuM8pFXrjhHBpokK41

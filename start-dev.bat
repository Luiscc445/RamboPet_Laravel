@echo off
REM Script para iniciar el entorno de desarrollo completo de RamboPet

echo ========================================
echo   RamboPet - Inicio de Desarrollo
echo ========================================
echo.
echo Este script te ayudara a iniciar:
echo   1. Backend Laravel (Puerto 8000)
echo   2. Tunel ngrok
echo   3. App movil React Native
echo.
echo Presiona cualquier tecla para continuar...
pause >nul
cls

echo ========================================
echo   Paso 1: Verificar instalaciones
echo ========================================
echo.

REM Verificar PHP
echo Verificando PHP...
php --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × PHP no encontrado. Instala XAMPP o PHP
    pause
    exit /b 1
)
echo ✓ PHP instalado

REM Verificar Composer
echo Verificando Composer...
composer --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × Composer no encontrado
    pause
    exit /b 1
)
echo ✓ Composer instalado

REM Verificar Node.js
echo Verificando Node.js...
node --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × Node.js no encontrado
    pause
    exit /b 1
)
echo ✓ Node.js instalado

REM Verificar ngrok
echo Verificando ngrok...
ngrok version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × ngrok no encontrado. Descarga desde https://ngrok.com/download
    pause
    exit /b 1
)
echo ✓ ngrok instalado

echo.
echo ========================================
echo   Paso 2: Configurar ngrok
echo ========================================
echo.
echo Configurando authtoken de ngrok...
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG
echo ✓ Authtoken configurado

echo.
echo ========================================
echo   Paso 3: Iniciar servicios
echo ========================================
echo.
echo ABRIENDO 3 VENTANAS:
echo   - Terminal 1: Backend Laravel
echo   - Terminal 2: Tunel ngrok
echo   - Terminal 3: App movil (puedes cerrarla si usas otra terminal)
echo.
timeout /t 3 /nobreak >nul

REM Iniciar backend Laravel en nueva ventana
start "RamboPet - Backend Laravel" cmd /k "php artisan serve && pause"

REM Esperar 3 segundos
timeout /t 3 /nobreak >nul

REM Iniciar ngrok en nueva ventana
start "RamboPet - ngrok Tunnel" cmd /k "ngrok http 8000"

echo.
echo ========================================
echo   IMPORTANTE - Configuracion final
echo ========================================
echo.
echo 1. Espera a que ngrok se inicie (ventana nueva)
echo 2. Copia la URL HTTPS de ngrok (ej: https://xxxx-xxxx.ngrok-free.dev)
echo 3. Edita el archivo: mobile\src\utils\constants.js
echo 4. Cambia API_BASE_URL a: https://TU-URL-NGROK/api/mobile
echo 5. Guarda el archivo
echo 6. En la carpeta mobile, ejecuta: npm start
echo 7. Escanea el QR con Expo Go en tu telefono
echo.
echo ========================================
echo.
echo ¿Quieres abrir la carpeta mobile ahora? (S/N)
set /p OPEN_MOBILE="Respuesta: "

if /i "%OPEN_MOBILE%"=="S" (
    start "" explorer "mobile"
    echo.
    echo Para iniciar la app movil, ejecuta en mobile:
    echo   npm start
)

echo.
echo Presiona cualquier tecla para cerrar este script...
echo (Las otras ventanas seguiran abiertas)
pause >nul

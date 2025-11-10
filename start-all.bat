@echo off
REM Script maestro para iniciar TODO el entorno RamboPet

echo ========================================
echo   RamboPet - Inicio Completo
echo ========================================
echo.
echo Este script iniciara:
echo   1. Backend Laravel (Puerto 8000)
echo   2. Frontend React Native Web (Puerto 8081)
echo   3. Doble Tunel ngrok
echo.
echo Presiona cualquier tecla para continuar...
pause >nul
cls

echo ========================================
echo   Verificando instalaciones
echo ========================================
echo.

REM Verificar PHP
php --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × PHP no encontrado
    pause
    exit /b 1
)
echo ✓ PHP instalado

REM Verificar Node.js
node --version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × Node.js no encontrado
    pause
    exit /b 1
)
echo ✓ Node.js instalado

REM Verificar ngrok
ngrok version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × ngrok no encontrado
    pause
    exit /b 1
)
echo ✓ ngrok instalado

echo.
echo ========================================
echo   Configurando ngrok
echo ========================================
echo.
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG
echo ✓ Authtoken configurado

echo.
echo ========================================
echo   Iniciando servicios
echo ========================================
echo.
echo ABRIENDO 3 VENTANAS:
echo   - Terminal 1: Backend Laravel (Puerto 8000)
echo   - Terminal 2: Frontend React Native Web (Puerto 8081)
echo   - Terminal 3: Doble Tunel ngrok
echo.
timeout /t 2 /nobreak >nul

REM Terminal 1: Backend Laravel
start "RamboPet - Backend Laravel" cmd /k "php artisan serve && pause"

timeout /t 3 /nobreak >nul

REM Terminal 2: Frontend React Native Web
start "RamboPet - Frontend React Web" cmd /k "cd mobile && npm run web"

timeout /t 5 /nobreak >nul

REM Terminal 3: Doble túnel ngrok
start "RamboPet - ngrok Dual Tunnel" cmd /k "ngrok start --all --config ngrok.yml"

echo.
echo ========================================
echo   IMPORTANTE - URLs de ngrok
echo ========================================
echo.
echo 1. Ve a la ventana "RamboPet - ngrok Dual Tunnel"
echo 2. Veras 2 URLs HTTPS:
echo    - backend    : https://xxxx.ngrok-free.dev (Laravel API)
echo    - frontend   : https://yyyy.ngrok-free.dev (React Native Web)
echo.
echo 3. Para acceder desde el navegador:
echo    - Abre la URL del FRONTEND en tu navegador
echo    - Veras la app movil de RamboPet funcionando
echo.
echo 4. Para acceder desde el telefono:
echo    - Instala Expo Go
echo    - Abre Expo Go y escanea el QR de la terminal "Frontend React Web"
echo.
echo ========================================
echo.
echo Presiona cualquier tecla para cerrar este script...
echo (Las otras ventanas seguiran abiertas)
pause >nul

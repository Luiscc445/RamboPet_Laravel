@echo off
REM Script para iniciar DOBLE túnel ngrok: Backend Laravel + Frontend React Native

echo ========================================
echo   RamboPet - Doble Tunel ngrok
echo ========================================
echo.

REM Verificar que ngrok esté instalado
ngrok version >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo × Error: ngrok no esta instalado
    echo.
    echo Descarga ngrok desde: https://ngrok.com/download
    pause
    exit /b 1
)

echo [1/2] Configurando authtoken de ngrok...
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG

if %ERRORLEVEL% EQU 0 (
    echo ✓ Authtoken configurado
) else (
    echo × Error al configurar authtoken
    pause
    exit /b 1
)

echo.
echo [2/2] Iniciando DOBLE tunel ngrok...
echo.
echo ========================================
echo   Tuneles Activos:
echo ========================================
echo   1. Backend Laravel  : Puerto 8000
echo   2. Frontend React   : Puerto 8081
echo ========================================
echo.
echo IMPORTANTE:
echo - El backend Laravel debe estar corriendo: php artisan serve
echo - La app React Native debe estar corriendo: npm run web (en carpeta mobile)
echo.
echo Presiona Ctrl+C para detener los tuneles
echo.
echo Las URLs apareceran a continuacion...
echo.

REM Iniciar ambos túneles usando el archivo de configuración
ngrok start --all --config ngrok.yml

pause

@echo off
REM Script para configurar y ejecutar ngrok con RamboPet

echo ========================================
echo   RamboPet - Configuracion de ngrok
echo ========================================
echo.

REM Configurar authtoken
echo [1/2] Configurando authtoken de ngrok...
ngrok config add-authtoken 35GVso3SIgSSI84JGlWOePw39fL_7vjXVGFs4G7hE2biAMnFG

if %ERRORLEVEL% EQU 0 (
    echo ✓ Authtoken configurado exitosamente
) else (
    echo × Error al configurar authtoken
    pause
    exit /b 1
)

echo.
echo [2/2] Iniciando tunel ngrok en puerto 8000...
echo.
echo IMPORTANTE:
echo - El backend Laravel debe estar corriendo en http://localhost:8000
echo - Ejecuta "php artisan serve" en otra terminal
echo - Copia la URL HTTPS que aparecera a continuacion
echo - Actualiza mobile/src/utils/constants.js con la nueva URL
echo.
echo Presiona Ctrl+C para detener ngrok
echo.

REM Iniciar ngrok
ngrok http 8000

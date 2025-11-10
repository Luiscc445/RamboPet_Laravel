@echo off
REM Script para crear túnel público usando localtunnel

echo ========================================
echo   RamboPet - Túnel Web (Localtunnel)
echo ========================================
echo.
echo Este script creará un túnel público para probar
echo la app móvil desde cualquier navegador web.
echo.
echo IMPORTANTE:
echo   1. Asegúrate de tener la app móvil corriendo (start-mobile.bat)
echo   2. El túnel expondrá el puerto 8081 públicamente
echo   3. Recibirás una URL pública (ej: https://xxxx.loca.lt)
echo.
echo Presiona Ctrl+C para detener
echo.

cd mobile
npm run tunnel

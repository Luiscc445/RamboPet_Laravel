@echo off
REM Script para iniciar la app móvil React Native

echo ========================================
echo   RamboPet - App Móvil
echo ========================================
echo.
echo Iniciando app móvil en puerto 8081
echo.
echo Opciones disponibles:
echo   - Escanear QR con Expo Go (Android/iOS)
echo   - Presionar 'w' para abrir en navegador web
echo.
echo Presiona Ctrl+C para detener
echo.

cd mobile
npm start

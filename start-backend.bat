@echo off
REM Script para iniciar el backend Laravel en puerto 8000

echo ========================================
echo   RamboPet - Backend Laravel
echo ========================================
echo.
echo Iniciando servidor en http://localhost:8000
echo Presiona Ctrl+C para detener
echo.

php artisan serve --port=8000

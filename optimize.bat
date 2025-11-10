@echo off
echo ========================================
echo   OPTIMIZACION EXTREMA - RamboPet
echo ========================================
echo.

echo [1/5] Limpiando cache anterior...
php artisan optimize:clear

echo.
echo [2/5] Cacheando configuracion...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo.
echo [3/5] Optimizando Composer...
composer dump-autoload --optimize --classmap-authoritative

echo.
echo [4/5] Actualizando estadisticas PostgreSQL...
php artisan tinker --execute="try { DB::statement('ANALYZE'); echo 'Estadisticas actualizadas'; } catch (Exception $e) { echo 'DB no disponible (ejecutar despues)'; }"

echo.
echo ========================================
echo   OPTIMIZACION COMPLETADA
echo ========================================
echo.
echo IMPORTANTE:
echo - Cache habilitado (cambios en config NO se reflejaran)
echo - Para desarrollo: php artisan optimize:clear
echo - Para produccion: ejecuta este script antes de deploy
echo.
echo Inicia el servidor con:
echo   php artisan serve --port=8000
echo.
pause

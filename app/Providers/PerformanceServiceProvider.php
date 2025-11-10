<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * Optimizaciones SUPER AGRESIVAS de rendimiento
     */
    public function boot(): void
    {
        // 1. OPTIMIZACIÓN: Deshabilitar logs en queries SIEMPRE (modo producción)
        if (!config('app.debug')) {
            DB::disableQueryLog();
        }

        // 2. OPTIMIZACIÓN: Lazy loading estricto (detecta N+1)
        Model::preventLazyLoading(config('app.env') !== 'production');

        // 2.1 OPTIMIZACIÓN AGRESIVA: Deshabilitar mass assignment protection en producción
        // ADVERTENCIA: Solo si confías en tu código
        if (config('app.env') === 'production') {
            Model::unguard();
        }

        // 3. OPTIMIZACIÓN: Cache agresivo de queries comunes
        $this->cacheCommonQueries();

        // 4. OPTIMIZACIÓN: Connection pooling settings AGRESIVO
        config([
            'database.connections.pgsql.options' => array_merge(
                config('database.connections.pgsql.options', []),
                [
                    \PDO::ATTR_PERSISTENT => true,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_TIMEOUT => 5,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            ),
        ]);

        // 5. OPTIMIZACIÓN AGRESIVA: Deshabilitar eventos innecesarios
        if (!config('app.debug')) {
            // Deshabilitar eventos de modelo que no necesites
            Model::withoutEvents(function() {
                // Los modelos no dispararán eventos dentro de este scope
            });
        }

        // 6. OPTIMIZACIÓN: Reducir memoria en produción
        if (config('app.env') === 'production') {
            ini_set('memory_limit', '128M'); // Ajustar según necesidad
        }
    }

    /**
     * Cache queries comunes por 1 hora
     */
    private function cacheCommonQueries(): void
    {
        // Solo en producción o si cache está habilitado
        if (!config('app.debug')) {
            try {
                // Cache de especies (raramente cambian)
                if (!Cache::has('especies_all')) {
                    Cache::remember('especies_all', 3600, function () {
                        return \App\Models\Especie::all();
                    });
                }

                // Cache de razas por especie
                if (!Cache::has('razas_all')) {
                    Cache::remember('razas_all', 3600, function () {
                        return \App\Models\Raza::with('especie')->get();
                    });
                }

                // Cache de veterinarios activos
                if (!Cache::has('veterinarios_activos')) {
                    Cache::remember('veterinarios_activos', 600, function () {
                        return \App\Models\User::where('rol', 'veterinario')
                            ->where('activo', true)
                            ->select('id', 'name', 'email')
                            ->get();
                    });
                }
            } catch (\Exception $e) {
                // Silently fail during installation or if cache/DB not ready
                // This is expected during composer install
            }
        }
    }
}

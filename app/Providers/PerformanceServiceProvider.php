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
     * Optimizaciones extremas de rendimiento
     */
    public function boot(): void
    {
        // 1. OPTIMIZACIÓN: Deshabilitar logs en queries (modo producción)
        if (!config('app.debug')) {
            DB::disableQueryLog();
        }

        // 2. OPTIMIZACIÓN: Lazy loading estricto (detecta N+1)
        Model::preventLazyLoading(config('app.env') !== 'production');

        // 3. OPTIMIZACIÓN: Cache agresivo de queries comunes
        $this->cacheCommonQueries();

        // 4. OPTIMIZACIÓN: Connection pooling settings
        config([
            'database.connections.pgsql.options' => array_merge(
                config('database.connections.pgsql.options', []),
                [
                    \PDO::ATTR_PERSISTENT => true,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_TIMEOUT => 5,
                ]
            ),
        ]);
    }

    /**
     * Cache queries comunes por 1 hora
     */
    private function cacheCommonQueries(): void
    {
        // Solo en producción o si cache está habilitado
        if (!config('app.debug')) {
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
        }
    }
}

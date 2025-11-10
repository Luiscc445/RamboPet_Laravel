<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Optimizaciones de Rendimiento Filament
    |--------------------------------------------------------------------------
    |
    | Configuraciones agresivas para máximo rendimiento
    |
    */

    // Lazy loading de relaciones
    'lazy_load_tables' => true,

    // Número de registros por página (menos = más rápido)
    'default_pagination_page_size' => 15,

    // Deshabilitar notifications por defecto
    'default_notifications' => false,

    // Cache de navegación
    'cache_navigation' => true,
    'cache_navigation_seconds' => 3600,

    // Debouncing en búsquedas (ms)
    'search_debounce' => 300,

    // Optimizar assets
    'optimize_assets' => env('APP_ENV', 'production') !== 'local',

];

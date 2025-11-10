<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\Filament\VeterinarioPanelProvider;
use App\Providers\Filament\LaboratorioPanelProvider;
use App\Providers\Filament\ImagenologiaPanelProvider;
use App\Providers\Filament\RecepcionPanelProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        VeterinarioPanelProvider::class,
        LaboratorioPanelProvider::class,
        ImagenologiaPanelProvider::class,
        RecepcionPanelProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'check.admin' => \App\Http\Middleware\CheckAdmin::class,
            'check.veterinario' => \App\Http\Middleware\CheckVeterinario::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

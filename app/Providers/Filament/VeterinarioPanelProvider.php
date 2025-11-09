<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class VeterinarioPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('veterinario')
            ->path('veterinario')
            ->login()
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
                'success' => Color::Green,
                'info' => Color::Cyan,
                'warning' => Color::Amber,
                'danger' => Color::Red,
            ])
            ->font('Inter')
            ->discoverResources(in: app_path('Filament/Veterinario/Resources'), for: 'App\\Filament\\Veterinario\\Resources')
            ->discoverPages(in: app_path('Filament/Veterinario/Pages'), for: 'App\\Filament\\Veterinario\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Veterinario/Widgets'), for: 'App\\Filament\\Veterinario\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web')
            ->spa()
            ->brandName('RamboPet - Veterinario')
            ->brandLogo(fn () => view('components.logo'))
            ->favicon(asset('favicon.ico'))
            ->darkMode(false)
            ->topNavigation(false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->maxContentWidth('full')
            ->navigationGroups([
                'Consultas',
                'Pacientes',
            ])
            ->breadcrumbs(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->profile()
            ->userMenuItems([
                'logout' => \Filament\Navigation\MenuItem::make()
                    ->label('Cerrar Sesión')
                    ->url(fn () => route('filament.veterinario.auth.logout'))
                    ->postAction()
            ]);
    }
}

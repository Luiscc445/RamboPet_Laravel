<?php

namespace App\Filament\Veterinario\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Panel Veterinario';

    protected static ?string $navigationLabel = 'Inicio';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Veterinario\Widgets\CitasHoyWidget::class,
            \App\Filament\Veterinario\Widgets\StatsVeterinarioWidget::class,
        ];
    }
}

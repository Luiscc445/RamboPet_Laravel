<?php

namespace App\Filament\Widgets;

use App\Models\Mascota;
use App\Models\Cita;
use App\Models\Tutor;
use App\Models\Producto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Mascotas Registradas', Mascota::count())
                ->description('Total de mascotas en el sistema')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->chart([7, 12, 10, 15, 18, 25, Mascota::count()]),

            Stat::make('Citas Hoy', Cita::whereDate('fecha_hora', today())->count())
                ->description('Citas programadas para hoy')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart([3, 5, 4, 7, 6, 8, Cita::whereDate('fecha_hora', today())->count()]),

            Stat::make('Tutores Activos', Tutor::where('activo', true)->count())
                ->description('Clientes registrados')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([45, 50, 55, 60, 65, 70, Tutor::where('activo', true)->count()]),

            Stat::make('Productos en Stock', Producto::sum('stock_actual'))
                ->description('Unidades en inventario')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning')
                ->chart([100, 120, 110, 130, 125, 140, Producto::sum('stock_actual')]),
        ];
    }
}

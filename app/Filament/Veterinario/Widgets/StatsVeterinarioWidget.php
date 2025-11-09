<?php

namespace App\Filament\Veterinario\Widgets;

use App\Models\Cita;
use App\Models\EpisodioClinico;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsVeterinarioWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $veterinarioId = Auth::id();

        return [
            Stat::make('Citas Hoy', Cita::where('veterinario_id', $veterinarioId)
                ->whereDate('fecha_hora', today())
                ->count())
                ->description('Citas programadas para hoy')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart([3, 5, 4, 7, 6, 8, Cita::where('veterinario_id', $veterinarioId)->whereDate('fecha_hora', today())->count()]),

            Stat::make('Citas Pendientes', Cita::where('veterinario_id', $veterinarioId)
                ->whereIn('estado', ['pendiente', 'confirmada'])
                ->whereDate('fecha_hora', '>=', today())
                ->count())
                ->description('Citas confirmadas próximas')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Atenciones del Mes', EpisodioClinico::where('veterinario_id', $veterinarioId)
                ->whereMonth('fecha', now()->month)
                ->count())
                ->description('Consultas realizadas este mes')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}

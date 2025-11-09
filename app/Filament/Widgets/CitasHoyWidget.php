<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CitasHoyWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = '📅 Citas de Hoy';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Cita::whereDate('fecha_hora', today())
                    ->with(['mascota.tutor', 'mascota.especie'])
                    ->orderBy('fecha_hora')
            )
            ->columns([
                Tables\Columns\TextColumn::make('fecha_hora')
                    ->label('Hora')
                    ->dateTime('H:i')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('mascota.nombre')
                    ->label('Mascota')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-heart')
                    ->iconColor('success'),

                Tables\Columns\TextColumn::make('mascota.especie.nombre')
                    ->label('Especie')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Perro' => 'warning',
                        'Gato' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('mascota.tutor.nombre')
                    ->label('Tutor')
                    ->searchable()
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo de Cita')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'consulta' => 'success',
                        'vacunacion' => 'info',
                        'cirugia' => 'danger',
                        'control' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmada' => 'success',
                        'en_proceso' => 'info',
                        'completada' => 'success',
                        'cancelada' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('fecha_hora')
            ->striped()
            ->emptyStateHeading('No hay citas programadas para hoy')
            ->emptyStateDescription('Las citas aparecerán aquí cuando se programen')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}

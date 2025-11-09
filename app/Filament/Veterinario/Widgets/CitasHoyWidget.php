<?php

namespace App\Filament\Veterinario\Widgets;

use App\Models\Cita;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class CitasHoyWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = '📅 Mis Citas de Hoy';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Cita::where('veterinario_id', Auth::id())
                    ->whereDate('fecha_hora', today())
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
                    ->label('Paciente')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-heart')
                    ->iconColor('success')
                    ->weight('bold'),

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

                Tables\Columns\TextColumn::make('tipo_consulta')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'consulta_general' => 'Consulta',
                        'vacunacion' => 'Vacunación',
                        'cirugia' => 'Cirugía',
                        'control' => 'Control',
                        'emergencia' => 'Emergencia',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'consulta_general' => 'success',
                        'vacunacion' => 'info',
                        'cirugia' => 'danger',
                        'control' => 'warning',
                        'emergencia' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmada' => 'success',
                        'en_curso' => 'info',
                        'completada' => 'success',
                        'cancelada' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('iniciar')
                    ->label('Iniciar Consulta')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->visible(fn (Cita $record) => $record->estado !== 'completada')
                    ->url(fn (Cita $record): string => route('filament.veterinario.resources.episodio-clinicos.create', [
                        'mascota_id' => $record->mascota_id,
                        'cita_id' => $record->id,
                    ])),
            ])
            ->defaultSort('fecha_hora')
            ->striped()
            ->emptyStateHeading('No tienes citas programadas para hoy')
            ->emptyStateDescription('Las citas aparecerán aquí cuando se programen')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}

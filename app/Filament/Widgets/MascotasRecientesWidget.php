<?php

namespace App\Filament\Widgets;

use App\Models\Mascota;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MascotasRecientesWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = '🐾 Mascotas Registradas Recientemente';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Mascota::with(['tutor', 'especie', 'raza'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Mascota&color=10b981&background=d1fae5'),

                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-heart')
                    ->iconColor('primary'),

                Tables\Columns\TextColumn::make('especie.nombre')
                    ->label('Especie')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Perro' => 'warning',
                        'Gato' => 'info',
                        'Ave' => 'success',
                        'Roedor' => 'gray',
                        'Reptil' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('raza.nombre')
                    ->label('Raza')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'macho' => 'info',
                        'hembra' => 'pink',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('tutor.nombre')
                    ->label('Tutor')
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->iconColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->since()
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('No hay mascotas registradas')
            ->emptyStateDescription('Las mascotas aparecerán aquí cuando se registren')
            ->emptyStateIcon('heroicon-o-heart');
    }
}

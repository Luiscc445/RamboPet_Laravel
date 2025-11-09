<?php

namespace App\Filament\Laboratorio\Resources;

use App\Filament\Laboratorio\Resources\ExamenLaboratorioResource\Pages;
use App\Models\ExamenLaboratorio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExamenLaboratorioResource extends Resource
{
    protected static ?string $model = ExamenLaboratorio::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Exámenes';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Examen de Laboratorio';

    protected static ?string $pluralModelLabel = 'Exámenes de Laboratorio';

    protected static ?string $navigationLabel = 'Mis Exámenes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Examen')
                    ->schema([
                        Forms\Components\Select::make('mascota_id')
                            ->label('Paciente')
                            ->relationship('mascota', 'nombre')
                            ->searchable()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('veterinario_id')
                            ->label('Veterinario Solicitante')
                            ->relationship('veterinario', 'name')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('tipo_examen')
                            ->label('Tipo de Examen')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'en_proceso' => 'En Proceso',
                                'completado' => 'Completado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('prioridad')
                            ->label('Prioridad')
                            ->options([
                                'normal' => 'Normal',
                                'urgente' => 'Urgente',
                                'stat' => 'STAT',
                            ])
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Textarea::make('indicaciones')
                            ->label('Indicaciones del Veterinario')
                            ->rows(2)
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Procesamiento')
                    ->schema([
                        Forms\Components\Hidden::make('laboratorista_id')
                            ->default(Auth::id()),

                        Forms\Components\DateTimePicker::make('fecha_toma_muestra')
                            ->label('Fecha de Toma de Muestra')
                            ->displayFormat('d/m/Y H:i'),

                        Forms\Components\DateTimePicker::make('fecha_resultado')
                            ->label('Fecha de Resultado')
                            ->displayFormat('d/m/Y H:i')
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Resultados')
                    ->schema([
                        Forms\Components\KeyValue::make('resultados')
                            ->label('Valores de Laboratorio')
                            ->keyLabel('Parámetro')
                            ->valueLabel('Valor')
                            ->addActionLabel('Agregar Parámetro')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('interpretacion')
                            ->label('Interpretación de Resultados')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Interpretación profesional de los resultados obtenidos'),

                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones Adicionales')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                ExamenLaboratorio::with(['mascota.tutor', 'veterinario'])
                    ->orderBy('prioridad', 'asc')
                    ->orderBy('fecha_solicitud', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->label('Fecha Solicitud')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mascota.nombre')
                    ->label('Paciente')
                    ->searchable()
                    ->icon('heroicon-o-heart')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('mascota.tutor.nombre')
                    ->label('Tutor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo_examen')
                    ->label('Tipo de Examen')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('veterinario.name')
                    ->label('Solicitado por')
                    ->searchable(),

                Tables\Columns\TextColumn::make('prioridad')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'stat' => 'danger',
                        'urgente' => 'warning',
                        'normal' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'stat' => 'STAT',
                        'urgente' => 'URGENTE',
                        'normal' => 'Normal',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'en_proceso' => 'info',
                        'completado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('laboratorista.name')
                    ->label('Procesado por')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fecha_resultado')
                    ->label('Fecha Resultado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_proceso' => 'En Proceso',
                        'completado' => 'Completado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('pendiente'),

                Tables\Filters\SelectFilter::make('prioridad')
                    ->options([
                        'stat' => 'STAT',
                        'urgente' => 'Urgente',
                        'normal' => 'Normal',
                    ]),

                Tables\Filters\SelectFilter::make('tipo_examen')
                    ->label('Tipo de Examen'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_solicitud', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamenesLaboratorio::route('/'),
            'create' => Pages\CreateExamenLaboratorio::route('/create'),
            'view' => Pages\ViewExamenLaboratorio::route('/{record}'),
            'edit' => Pages\EditExamenLaboratorio::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Imagenologia\Resources;

use App\Filament\Imagenologia\Resources\ExamenImagenResource\Pages;
use App\Models\ExamenImagen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExamenImagenResource extends Resource
{
    protected static ?string $model = ExamenImagen::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Estudios';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Examen de Imagen';

    protected static ?string $pluralModelLabel = 'Exámenes de Imagen';

    protected static ?string $navigationLabel = 'Mis Estudios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Estudio')
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

                        Forms\Components\Select::make('tipo_examen')
                            ->label('Tipo de Estudio')
                            ->options([
                                'ecografia' => 'Ecografía',
                                'radiografia' => 'Radiografía',
                                'tomografia' => 'Tomografía',
                                'resonancia' => 'Resonancia Magnética',
                            ])
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('region_anatomica')
                            ->label('Región Anatómica')
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

                Forms\Components\Section::make('Realización del Estudio')
                    ->schema([
                        Forms\Components\Hidden::make('ecografista_id')
                            ->default(Auth::id()),

                        Forms\Components\DateTimePicker::make('fecha_realizacion')
                            ->label('Fecha de Realización')
                            ->displayFormat('d/m/Y H:i')
                            ->default(now()),

                        Forms\Components\DateTimePicker::make('fecha_informe')
                            ->label('Fecha del Informe')
                            ->displayFormat('d/m/Y H:i')
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Informe del Estudio')
                    ->schema([
                        Forms\Components\Textarea::make('hallazgos')
                            ->label('Hallazgos')
                            ->rows(5)
                            ->columnSpanFull()
                            ->helperText('Descripción detallada de los hallazgos del estudio'),

                        Forms\Components\Textarea::make('conclusion')
                            ->label('Conclusión')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Conclusión diagnóstica del estudio'),

                        Forms\Components\Textarea::make('recomendaciones')
                            ->label('Recomendaciones')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones Adicionales')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('archivos_imagenes')
                            ->label('Archivos de Imágenes (URLs)')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Ingrese las rutas o URLs de las imágenes, una por línea')
                            ->placeholder('ejemplo: /storage/imagenes/estudio_123_imagen1.jpg'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                ExamenImagen::with(['mascota.tutor', 'veterinario'])
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
                    ->label('Tipo de Estudio')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ecografia' => 'info',
                        'radiografia' => 'warning',
                        'tomografia' => 'primary',
                        'resonancia' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('region_anatomica')
                    ->label('Región')
                    ->searchable(),

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

                Tables\Columns\TextColumn::make('ecografista.name')
                    ->label('Realizado por')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fecha_informe')
                    ->label('Fecha Informe')
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
                    ->label('Tipo de Estudio')
                    ->options([
                        'ecografia' => 'Ecografía',
                        'radiografia' => 'Radiografía',
                        'tomografia' => 'Tomografía',
                        'resonancia' => 'Resonancia Magnética',
                    ]),
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
            'index' => Pages\ListExamenesImagen::route('/'),
            'create' => Pages\CreateExamenImagen::route('/create'),
            'view' => Pages\ViewExamenImagen::route('/{record}'),
            'edit' => Pages\EditExamenImagen::route('/{record}/edit'),
        ];
    }
}

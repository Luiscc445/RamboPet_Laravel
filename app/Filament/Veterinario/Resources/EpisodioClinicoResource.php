<?php

namespace App\Filament\Veterinario\Resources;

use App\Filament\Veterinario\Resources\EpisodioClinicoResource\Pages;
use App\Models\EpisodioClinico;
use App\Models\Mascota;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class EpisodioClinicoResource extends Resource
{
    protected static ?string $model = EpisodioClinico::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Consultas';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Episodio Clínico';

    protected static ?string $pluralModelLabel = 'Episodios Clínicos';

    protected static ?string $navigationLabel = 'Mis Atenciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Paciente')
                    ->schema([
                        Forms\Components\Select::make('mascota_id')
                            ->label('Paciente')
                            ->relationship('mascota', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('veterinario_id', Auth::id())
                            ),

                        Forms\Components\Select::make('cita_id')
                            ->label('Cita Asociada')
                            ->relationship('cita', 'id')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                $record->fecha_hora->format('d/m/Y H:i') . ' - ' . $record->tipo_consulta
                            ),

                        Forms\Components\Hidden::make('veterinario_id')
                            ->default(Auth::id()),

                        Forms\Components\DateTimePicker::make('fecha')
                            ->label('Fecha y Hora')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y H:i'),
                    ])->columns(2),

                Forms\Components\Section::make('Consulta')
                    ->schema([
                        Forms\Components\Textarea::make('motivo_consulta')
                            ->label('Motivo de Consulta')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('anamnesis')
                            ->label('Anamnesis')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Examen Físico')
                    ->schema([
                        Forms\Components\TextInput::make('peso')
                            ->label('Peso (kg)')
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('temperatura')
                            ->label('Temperatura (°C)')
                            ->numeric()
                            ->step(0.1),

                        Forms\Components\TextInput::make('frecuencia_cardiaca')
                            ->label('Frecuencia Cardíaca (lpm)')
                            ->numeric(),

                        Forms\Components\TextInput::make('frecuencia_respiratoria')
                            ->label('Frecuencia Respiratoria (rpm)')
                            ->numeric(),

                        Forms\Components\Textarea::make('examen_fisico')
                            ->label('Hallazgos del Examen Físico')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(4),

                Forms\Components\Section::make('Diagnóstico y Tratamiento')
                    ->schema([
                        Forms\Components\Textarea::make('diagnostico')
                            ->label('Diagnóstico')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('tratamiento')
                            ->label('Plan de Tratamiento')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('medicamentos')
                            ->label('Medicamentos Recetados')
                            ->schema([
                                Forms\Components\Select::make('producto_id')
                                    ->label('Medicamento')
                                    ->options(Producto::where('tipo', 'medicamento')->pluck('nombre', 'id'))
                                    ->searchable()
                                    ->required(),

                                Forms\Components\TextInput::make('dosis')
                                    ->label('Dosis')
                                    ->required()
                                    ->placeholder('Ej: 1 comprimido cada 12 horas'),

                                Forms\Components\TextInput::make('duracion')
                                    ->label('Duración')
                                    ->required()
                                    ->placeholder('Ej: 7 días'),

                                Forms\Components\Textarea::make('instrucciones')
                                    ->label('Instrucciones Especiales')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Agregar Medicamento')
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('examenes_solicitados')
                            ->label('Exámenes Solicitados')
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre del Examen')
                                    ->required(),

                                Forms\Components\Textarea::make('indicaciones')
                                    ->label('Indicaciones')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Agregar Examen')
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('proxima_visita')
                            ->label('Próxima Visita')
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Select::make('estado')
                            ->label('Estado del Episodio')
                            ->options([
                                'abierto' => 'Abierto',
                                'cerrado' => 'Cerrado',
                            ])
                            ->default('abierto')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Observaciones')
                    ->schema([
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
                EpisodioClinico::where('veterinario_id', Auth::id())
                    ->with(['mascota.tutor', 'mascota.especie'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mascota.nombre')
                    ->label('Paciente')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-heart')
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('motivo_consulta')
                    ->label('Motivo')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\TextColumn::make('diagnostico')
                    ->label('Diagnóstico')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'abierto' => 'warning',
                        'cerrado' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'abierto' => 'Abierto',
                        'cerrado' => 'Cerrado',
                    ]),

                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['desde'], fn ($q) => $q->whereDate('fecha', '>=', $data['desde']))
                            ->when($data['hasta'], fn ($q) => $q->whereDate('fecha', '<=', $data['hasta']));
                    }),
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
            ->defaultSort('fecha', 'desc');
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
            'index' => Pages\ListEpisodiosClinicos::route('/'),
            'create' => Pages\CreateEpisodioClinico::route('/create'),
            'view' => Pages\ViewEpisodioClinico::route('/{record}'),
            'edit' => Pages\EditEpisodioClinico::route('/{record}/edit'),
        ];
    }
}

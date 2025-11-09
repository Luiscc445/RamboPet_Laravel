<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CitaResource\Pages;
use App\Models\Cita;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Gestión Clínica';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Cita';

    protected static ?string $pluralModelLabel = 'Citas';

    protected static ?string $navigationLabel = 'Agenda de Citas';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('fecha_hora', today())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::whereDate('fecha_hora', today())->count();
        return $count > 10 ? 'danger' : ($count > 5 ? 'warning' : 'info');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Cita')
                    ->schema([
                        Forms\Components\Select::make('mascota_id')
                            ->label('Mascota')
                            ->relationship('mascota', 'nombre')
                            ->searchable()
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('veterinario_id')
                            ->label('Veterinario')
                            ->options(
                                User::where('rol', 'veterinario')
                                    ->where('activo', true)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        Forms\Components\DateTimePicker::make('fecha_hora')
                            ->label('Fecha y Hora')
                            ->required()
                            ->displayFormat('d/m/Y H:i')
                            ->minDate(now()),
                        Forms\Components\TextInput::make('duracion_minutos')
                            ->label('Duración (minutos)')
                            ->numeric()
                            ->default(30)
                            ->required()
                            ->minValue(15)
                            ->maxValue(240),
                    ])->columns(2),

                Forms\Components\Section::make('Detalles')
                    ->schema([
                        Forms\Components\Select::make('tipo_consulta')
                            ->label('Tipo de Consulta')
                            ->options([
                                'consulta_general' => 'Consulta General',
                                'vacunacion' => 'Vacunación',
                                'cirugia' => 'Cirugía',
                                'control' => 'Control',
                                'emergencia' => 'Emergencia',
                            ])
                            ->required()
                            ->default('consulta_general'),
                        Forms\Components\Select::make('estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'confirmada' => 'Confirmada',
                                'en_curso' => 'En Curso',
                                'completada' => 'Completada',
                                'cancelada' => 'Cancelada',
                                'perdida' => 'Perdida',
                            ])
                            ->required()
                            ->default('pendiente'),
                        Forms\Components\Textarea::make('motivo')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('confirmada')
                            ->default(false),
                        Forms\Components\Toggle::make('recordatorio_enviado')
                            ->label('Recordatorio Enviado')
                            ->default(false)
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha_hora')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('mascota.nombre')
                    ->label('Mascota')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mascota.tutor.nombre_completo')
                    ->label('Tutor')
                    ->searchable(['tutores.nombre', 'tutores.apellido'])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('veterinario.name')
                    ->label('Veterinario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_consulta')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'emergencia' => 'danger',
                        'cirugia' => 'warning',
                        'vacunacion' => 'success',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmada' => 'info',
                        'en_curso' => 'primary',
                        'completada' => 'success',
                        'cancelada' => 'danger',
                        'perdida' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('confirmada')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('recordatorio_enviado')
                    ->label('Recordatorio')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmada' => 'Confirmada',
                        'en_curso' => 'En Curso',
                        'completada' => 'Completada',
                        'cancelada' => 'Cancelada',
                        'perdida' => 'Perdida',
                    ]),
                Tables\Filters\SelectFilter::make('tipo_consulta')
                    ->label('Tipo de Consulta')
                    ->options([
                        'consulta_general' => 'Consulta General',
                        'vacunacion' => 'Vacunación',
                        'cirugia' => 'Cirugía',
                        'control' => 'Control',
                        'emergencia' => 'Emergencia',
                    ]),
                Tables\Filters\Filter::make('fecha_hora')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['desde'], fn ($q, $date) => $q->whereDate('fecha_hora', '>=', $date))
                            ->when($data['hasta'], fn ($q, $date) => $q->whereDate('fecha_hora', '<=', $date));
                    }),
                Tables\Filters\TrashedFilter::make(),
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
            ->defaultSort('fecha_hora', 'asc');
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
            'index' => Pages\ListCitas::route('/'),
            'create' => Pages\CreateCita::route('/create'),
            'view' => Pages\ViewCita::route('/{record}'),
            'edit' => Pages\EditCita::route('/{record}/edit'),
        ];
    }
}

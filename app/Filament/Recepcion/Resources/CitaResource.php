<?php

namespace App\Filament\Recepcion\Resources;

use App\Filament\Recepcion\Resources\CitaResource\Pages;
use App\Models\Cita;
use App\Models\Mascota;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Agenda';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Cita';

    protected static ?string $pluralModelLabel = 'Citas';

    protected static ?string $navigationLabel = 'Gestión de Citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Paciente')
                    ->schema([
                        Forms\Components\Select::make('mascota_id')
                            ->label('Mascota')
                            ->relationship('mascota', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                $record->nombre . ' - ' . $record->tutor->nombre
                            ),

                        Forms\Components\Select::make('veterinario_id')
                            ->label('Veterinario Asignado')
                            ->options(User::where('rol', 'veterinario')->where('activo', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Detalles de la Cita')
                    ->schema([
                        Forms\Components\DateTimePicker::make('fecha_hora')
                            ->label('Fecha y Hora')
                            ->required()
                            ->minDate(now())
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false),

                        Forms\Components\Select::make('tipo_consulta')
                            ->label('Tipo de Consulta')
                            ->options([
                                'consulta_general' => 'Consulta General',
                                'vacunacion' => 'Vacunación',
                                'cirugia' => 'Cirugía',
                                'urgencia' => 'Urgencia',
                                'control' => 'Control',
                                'peluqueria' => 'Peluquería',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'confirmada' => 'Confirmada',
                                'en_atencion' => 'En Atención',
                                'completada' => 'Completada',
                                'cancelada' => 'Cancelada',
                                'no_asistio' => 'No Asistió',
                            ])
                            ->default('pendiente')
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('motivo')
                            ->label('Motivo de la Consulta')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Descripción breve del motivo de la consulta'),

                        Forms\Components\Textarea::make('notas_recepcion')
                            ->label('Notas de Recepción')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Notas internas para el equipo'),

                        Forms\Components\Hidden::make('creado_por')
                            ->default(Auth::id()),
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
                    ->label('Paciente')
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-heart'),

                Tables\Columns\TextColumn::make('mascota.tutor.nombre')
                    ->label('Tutor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mascota.tutor.telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tipo_consulta')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'urgencia' => 'danger',
                        'cirugia' => 'warning',
                        'vacunacion' => 'success',
                        'control' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('veterinario.name')
                    ->label('Veterinario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmada' => 'info',
                        'en_atencion' => 'primary',
                        'completada' => 'success',
                        'cancelada' => 'danger',
                        'no_asistio' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('confirmada')
                    ->label('Confirmada')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmada' => 'Confirmada',
                        'en_atencion' => 'En Atención',
                        'completada' => 'Completada',
                        'cancelada' => 'Cancelada',
                        'no_asistio' => 'No Asistió',
                    ])
                    ->default('pendiente'),

                Tables\Filters\SelectFilter::make('tipo_consulta')
                    ->options([
                        'consulta_general' => 'Consulta General',
                        'vacunacion' => 'Vacunación',
                        'cirugia' => 'Cirugía',
                        'urgencia' => 'Urgencia',
                        'control' => 'Control',
                        'peluqueria' => 'Peluquería',
                    ]),

                Tables\Filters\Filter::make('hoy')
                    ->label('Solo Hoy')
                    ->query(fn ($query) => $query->whereDate('fecha_hora', today())),

                Tables\Filters\Filter::make('esta_semana')
                    ->label('Esta Semana')
                    ->query(fn ($query) => $query->whereBetween('fecha_hora', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('confirmar')
                    ->label('Confirmar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Cita $record) => $record->update(['estado' => 'confirmada', 'confirmada' => true]))
                    ->visible(fn (Cita $record): bool => $record->estado === 'pendiente'),
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

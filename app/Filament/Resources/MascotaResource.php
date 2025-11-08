<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MascotaResource\Pages;
use App\Models\Mascota;
use App\Models\Especie;
use App\Models\Raza;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MascotaResource extends Resource
{
    protected static ?string $model = Mascota::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Gestión Clínica';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Mascota';

    protected static ?string $pluralModelLabel = 'Mascotas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Tutor')
                    ->schema([
                        Forms\Components\Select::make('tutor_id')
                            ->label('Tutor')
                            ->relationship('tutor', 'nombre')
                            ->searchable(['nombre', 'apellido', 'rut'])
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('rut')
                                    ->required(),
                                Forms\Components\TextInput::make('nombre')
                                    ->required(),
                                Forms\Components\TextInput::make('apellido')
                                    ->required(),
                                Forms\Components\TextInput::make('celular')
                                    ->required(),
                            ])
                            ->preload(),
                    ]),

                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('especie_id')
                            ->label('Especie')
                            ->relationship('especie', 'nombre')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('raza_id', null)),
                        Forms\Components\Select::make('raza_id')
                            ->label('Raza')
                            ->options(function (callable $get) {
                                $especieId = $get('especie_id');
                                if (!$especieId) {
                                    return [];
                                }
                                return Raza::where('especie_id', $especieId)
                                    ->pluck('nombre', 'id');
                            })
                            ->searchable(),
                        Forms\Components\DatePicker::make('fecha_nacimiento')
                            ->label('Fecha de Nacimiento')
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),
                        Forms\Components\Select::make('sexo')
                            ->options([
                                'macho' => 'Macho',
                                'hembra' => 'Hembra',
                            ])
                            ->required()
                            ->default('macho'),
                        Forms\Components\TextInput::make('color')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('peso')
                            ->numeric()
                            ->suffix('kg')
                            ->maxValue(999.99),
                        Forms\Components\TextInput::make('microchip')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Toggle::make('esterilizado')
                            ->label('Esterilizado/Castrado'),
                    ])->columns(2),

                Forms\Components\Section::make('Información Médica')
                    ->schema([
                        Forms\Components\Textarea::make('alergias')
                            ->rows(2),
                        Forms\Components\Textarea::make('condiciones_medicas')
                            ->label('Condiciones Médicas')
                            ->rows(2),
                        Forms\Components\Textarea::make('notas')
                            ->rows(3),
                        Forms\Components\Toggle::make('activo')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('tutor.nombre_completo')
                    ->label('Tutor')
                    ->searchable(['tutores.nombre', 'tutores.apellido'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('especie.nombre')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('raza.nombre')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('edad')
                    ->label('Edad')
                    ->suffix(' años')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('fecha_nacimiento', $direction === 'asc' ? 'desc' : 'asc');
                    }),
                Tables\Columns\TextColumn::make('sexo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'macho' => 'info',
                        'hembra' => 'warning',
                    }),
                Tables\Columns\IconColumn::make('esterilizado')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('especie')
                    ->relationship('especie', 'nombre'),
                Tables\Filters\SelectFilter::make('sexo')
                    ->options([
                        'macho' => 'Macho',
                        'hembra' => 'Hembra',
                    ]),
                Tables\Filters\TernaryFilter::make('esterilizado')
                    ->placeholder('Todos')
                    ->trueLabel('Esterilizados')
                    ->falseLabel('No Esterilizados'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListMascotas::route('/'),
            'create' => Pages\CreateMascota::route('/create'),
            'view' => Pages\ViewMascota::route('/{record}'),
            'edit' => Pages\EditMascota::route('/{record}/edit'),
        ];
    }
}

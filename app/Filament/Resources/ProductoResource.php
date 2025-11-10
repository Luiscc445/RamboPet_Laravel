<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Inventario';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereColumn('stock_actual', '<=', 'stock_minimo')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Productos con stock bajo';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('categoria')
                            ->label('Categoría')
                            ->options([
                                'medicamento' => 'Medicamento',
                                'vacuna' => 'Vacuna',
                                'alimento' => 'Alimento',
                                'accesorio' => 'Accesorio',
                                'insumo' => 'Insumo',
                            ])
                            ->required()
                            ->default('medicamento'),
                        Forms\Components\TextInput::make('unidad_medida')
                            ->label('Unidad de Medida')
                            ->required()
                            ->default('unidad')
                            ->maxLength(50),
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Inventario')
                    ->schema([
                        Forms\Components\TextInput::make('stock_actual')
                            ->label('Stock Actual')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->minValue(0),
                        Forms\Components\TextInput::make('stock_minimo')
                            ->label('Stock Mínimo')
                            ->numeric()
                            ->default(5)
                            ->required()
                            ->minValue(0),
                        Forms\Components\TextInput::make('stock_maximo')
                            ->label('Stock Máximo')
                            ->numeric()
                            ->default(100)
                            ->required()
                            ->minValue(0),
                    ])->columns(3),

                Forms\Components\Section::make('Precios')
                    ->schema([
                        Forms\Components\TextInput::make('precio_compra')
                            ->label('Precio de Compra')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->required(),
                        Forms\Components\TextInput::make('precio_venta')
                            ->label('Precio de Venta')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('requiere_receta')
                            ->label('Requiere Receta Médica')
                            ->default(false),
                        Forms\Components\Toggle::make('activo')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('categoria')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'medicamento' => 'danger',
                        'vacuna' => 'warning',
                        'alimento' => 'success',
                        'accesorio' => 'info',
                        'insumo' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_actual')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(function ($record) {
                        if ($record->stock_actual <= $record->stock_minimo) {
                            return 'danger';
                        } elseif ($record->stock_actual <= ($record->stock_minimo * 1.5)) {
                            return 'warning';
                        }
                        return 'success';
                    }),
                Tables\Columns\TextColumn::make('precio_venta')
                    ->label('Precio')
                    ->money('CLP')
                    ->sortable(),
                Tables\Columns\IconColumn::make('requiere_receta')
                    ->label('Receta')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->options([
                        'medicamento' => 'Medicamento',
                        'vacuna' => 'Vacuna',
                        'alimento' => 'Alimento',
                        'accesorio' => 'Accesorio',
                        'insumo' => 'Insumo',
                    ]),
                Tables\Filters\Filter::make('stock_bajo')
                    ->label('Stock Bajo')
                    ->query(fn ($query) => $query->whereColumn('stock_actual', '<=', 'stock_minimo')),
                Tables\Filters\TernaryFilter::make('activo')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),
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
            ->defaultSort('nombre', 'asc');
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'view' => Pages\ViewProducto::route('/{record}'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Imagenologia\Resources\ExamenImagenResource\Pages;

use App\Filament\Imagenologia\Resources\ExamenImagenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExamenImagen extends ViewRecord
{
    protected static string $resource = ExamenImagenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

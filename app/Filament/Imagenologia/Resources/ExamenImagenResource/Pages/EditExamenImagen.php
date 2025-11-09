<?php

namespace App\Filament\Imagenologia\Resources\ExamenImagenResource\Pages;

use App\Filament\Imagenologia\Resources\ExamenImagenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamenImagen extends EditRecord
{
    protected static string $resource = ExamenImagenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

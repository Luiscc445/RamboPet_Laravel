<?php

namespace App\Filament\Recepcion\Resources\CitaResource\Pages;

use App\Filament\Recepcion\Resources\CitaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCita extends EditRecord
{
    protected static string $resource = CitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\MascotaResource\Pages;

use App\Filament\Resources\MascotaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMascota extends ViewRecord
{
    protected static string $resource = MascotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

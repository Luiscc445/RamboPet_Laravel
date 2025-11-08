<?php

namespace App\Filament\Resources\MascotaResource\Pages;

use App\Filament\Resources\MascotaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMascota extends EditRecord
{
    protected static string $resource = MascotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Laboratorio\Resources\ExamenLaboratorioResource\Pages;

use App\Filament\Laboratorio\Resources\ExamenLaboratorioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamenLaboratorio extends EditRecord
{
    protected static string $resource = ExamenLaboratorioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Laboratorio\Resources\ExamenLaboratorioResource\Pages;

use App\Filament\Laboratorio\Resources\ExamenLaboratorioResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExamenLaboratorio extends ViewRecord
{
    protected static string $resource = ExamenLaboratorioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

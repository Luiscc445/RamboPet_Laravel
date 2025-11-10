<?php

namespace App\Filament\Recepcion\Resources\CitaResource\Pages;

use App\Filament\Recepcion\Resources\CitaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCitas extends ListRecords
{
    protected static string $resource = CitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

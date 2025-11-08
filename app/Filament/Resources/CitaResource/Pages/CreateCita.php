<?php

namespace App\Filament\Resources\CitaResource\Pages;

use App\Filament\Resources\CitaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCita extends CreateRecord
{
    protected static string $resource = CitaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['creado_por'] = auth()->id();

        return $data;
    }
}

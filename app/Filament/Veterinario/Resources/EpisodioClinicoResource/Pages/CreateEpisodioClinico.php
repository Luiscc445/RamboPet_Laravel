<?php

namespace App\Filament\Veterinario\Resources\EpisodioClinicoResource\Pages;

use App\Filament\Veterinario\Resources\EpisodioClinicoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEpisodioClinico extends CreateRecord
{
    protected static string $resource = EpisodioClinicoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['veterinario_id'] = auth()->id();

        return $data;
    }
}

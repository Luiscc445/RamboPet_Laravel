<?php

namespace App\Filament\Veterinario\Resources\EpisodioClinicoResource\Pages;

use App\Filament\Veterinario\Resources\EpisodioClinicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEpisodioClinico extends ViewRecord
{
    protected static string $resource = EpisodioClinicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Veterinario\Resources\EpisodioClinicoResource\Pages;

use App\Filament\Veterinario\Resources\EpisodioClinicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEpisodiosClinicos extends ListRecords
{
    protected static string $resource = EpisodioClinicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Atención'),
        ];
    }
}

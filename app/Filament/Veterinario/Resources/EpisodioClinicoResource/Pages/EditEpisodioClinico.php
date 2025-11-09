<?php

namespace App\Filament\Veterinario\Resources\EpisodioClinicoResource\Pages;

use App\Filament\Veterinario\Resources\EpisodioClinicoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEpisodioClinico extends EditRecord
{
    protected static string $resource = EpisodioClinicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\Artists\Pages;

use Filament\Facades\Filament;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Artists\ArtistResource;

class EditArtist extends EditRecord
{
    protected static string $resource = ArtistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/artists';
    }
}

<?php

namespace App\Filament\Resources\Artists\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Artists\ArtistResource;

class CreateArtist extends CreateRecord
{
    protected static string $resource = ArtistResource::class;

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/artists';
    }
}

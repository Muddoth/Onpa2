<?php

namespace App\Filament\Resources\Songs\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Songs\SongResource;

class CreateSong extends CreateRecord
{
    protected static string $resource = SongResource::class;

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/songs';
    }
}

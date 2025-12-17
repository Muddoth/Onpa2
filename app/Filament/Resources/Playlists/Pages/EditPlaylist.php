<?php

namespace App\Filament\Resources\Playlists\Pages;

use Filament\Facades\Filament;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Playlists\PlaylistResource;

class EditPlaylist extends EditRecord
{
    protected static string $resource = PlaylistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/playlists';
    }
}

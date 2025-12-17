<?php

namespace App\Filament\Resources\Playlists\Pages;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Playlists\PlaylistResource;

class CreatePlaylist extends CreateRecord
{
    protected static string $resource = PlaylistResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['profile_id'] = Auth::user()->profile->id;
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/playlists';
    }
}

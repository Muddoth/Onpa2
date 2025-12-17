<?php

namespace App\Filament\Resources\Profiles\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Profiles\ProfileResource;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/profiles';
    }
}

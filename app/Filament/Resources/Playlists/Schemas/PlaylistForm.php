<?php

namespace App\Filament\Resources\Playlists\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PlaylistForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required(),
            Textarea::make('description')
                ->nullable()
                ->columnSpanFull(),
            Select::make('songs')
                ->relationship('songs', 'name') // assumes Playlist model has 'songs' many-to-many relation
                ->multiple()
                ->preload()
                ->required(),
        ]);
    }
}

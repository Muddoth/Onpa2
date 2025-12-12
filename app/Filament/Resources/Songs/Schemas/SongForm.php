<?php

namespace App\Filament\Resources\Songs\Schemas;

use App\Models\Artist;
use App\Models\Tag;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class SongForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(null),
                FileUpload::make('image_path')
                    ->directory('songs')     // stored inside storage/app/public/songs
                    ->disk('public'),         // future-proof
                TextInput::make('album')
                    ->default(null),
                TextInput::make('file_path')
                    ->default(null),
                Select::make('Tags')
                    ->label('Tags')
                    ->options(Tag::all()->pluck('name', 'id')->toArray())
                    ->default(fn($record) => $record ? $record->tags->pluck('id')->toArray() : [])
                    ->multiple()           // enable multi-selection
                    ->searchable()
                    ->preload()
                    ->placeholder('Select Tags'),
                Select::make('Artist')
                    ->label('Artists')
                    ->options(Artist::all()->pluck('name', 'id')->toArray())
                    ->default(fn($record) => $record ? $record->artist_id : null)
                    ->searchable()
                    ->preload()
                    ->placeholder('Select Artists'),
            ]);
    }
}

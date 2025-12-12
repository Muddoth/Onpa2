<?php

namespace App\Filament\Resources\Songs\Schemas;

use App\Models\Tag;
use App\Models\Artist;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Html;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\View;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;


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
                Select::make('artist_id')   // foreign key column
                    ->label('Artist')
                    ->options(Artist::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->default(fn($record) => $record ? $record->artist_id : null)
                    ->placeholder('Select Artist'),
                // Upload audio file input
                FileUpload::make('file_path')
                    ->label('Audio File')
                    ->directory('audio')     // storage/app/public/audio
                    ->disk('public')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav']) // restrict to audio
                    ->maxSize(10240), // max size in KB (10 MB)
                // Show audio player preview if file_path exists
                View::make('components.audio_-player')
                    ->viewData(fn($get) => [
                        'filePath' => $get('file_path'),
                    ])
                    ->visible(fn($get) => !empty($get('file_path'))),
                Select::make('tags')        // lowercase, matches DB column
                    ->label('Tags')
                    ->options(Tag::all()->pluck('name', 'id')->toArray())
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->placeholder('Select tags')
                    ->default(fn($record) => $record ? json_decode($record->tags ?? '[]') : []),



            ]);
    }
}

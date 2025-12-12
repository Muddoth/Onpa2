<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Models\Tag;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('profile_picture')
                    ->label('Profile Picture')
                    ->image()
                    ->extraInputAttributes(['style' => 'border-radius: 50%; overflow: hidden;'])
                    ->columnSpanFull()  // <-- makes it take full row
                    ->maxSize(1024),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('age')
                    ->required()
                    ->numeric(),
                TextInput::make('gender')
                    ->required(),
                Textarea::make('bio')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('favourite_genres')
                    ->label('Favourite Genres / Tags')
                    ->options(Tag::all()->pluck('name', 'id')->toArray())
                    ->multiple()           // enable multi-selection
                    ->searchable()
                    ->preload()
                    ->placeholder('Select genres'),
            ]);
    }
}

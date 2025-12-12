<?php

namespace App\Filament\Resources\Profiles\Tables;

use App\Models\Tag;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable(),
                ImageColumn::make('profile_picture') // replace with your actual DB column name
                    ->label('Profile Picture')
                    ->circular() // optional: makes image circular like an avatar
                    ->height(50)  // set image height
                    ->width(50),  // set image width
                TextColumn::make('favourite_genres')
                    ->label('Favourite Genres')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;

                        // $state is JSON string or array of IDs
                        $tagIds = is_array($state) ? $state : json_decode($state, true);

                        if (!$tagIds || !is_array($tagIds)) return null;

                        // Fetch tag names from DB
                        $tagNames = Tag::whereIn('id', $tagIds)->pluck('name')->toArray();

                        // Join and return as comma-separated string
                        return implode(', ', $tagNames);
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

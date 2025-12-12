<?php

namespace App\Filament\Resources\Songs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SongsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->extraAttributes(['style' => 'width: 150px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;']),
                ImageColumn::make('image_path')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->image_path))
                    ->width(50)
                    ->circular(),
                TextColumn::make('album')
                    ->searchable(),
                TextColumn::make('file_path')
                    ->label('Audio')
                    ->formatStateUsing(fn($state) => '
                            <audio controls style="width: 150px;">
                                <source src="' . asset('storage/' . $state) . '" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        ')
                    ->html(),
                TextColumn::make('artist.name')
                    ->label('Artist')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

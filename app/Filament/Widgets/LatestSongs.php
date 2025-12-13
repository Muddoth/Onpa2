<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;

class LatestSongs extends TableWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {

        return $table
            ->query(Song::latest()->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->extraAttributes(['style' => 'width: 150px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;']),
                ImageColumn::make('image_path')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->image_path))
                    ->sortable()
                    ->toggleable() // allow toggle visibility
                    ->width(50)
                    ->circular(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}

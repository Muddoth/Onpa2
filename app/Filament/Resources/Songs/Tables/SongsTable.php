<?php

namespace App\Filament\Resources\Songs\Tables;

use App\Models\Tag;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Support\Icons\Heroicon;

class SongsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable() // allow toggle visibility
                    ->extraAttributes(['style' => 'width: 150px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;']),
                ImageColumn::make('image_path')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->image_path))
                    ->sortable()
                    ->toggleable() // allow toggle visibility
                    ->width(50)
                    ->circular(),
                TextColumn::make('album')
                    ->sortable()
                    ->toggleable() // allow toggle visibility
                    ->searchable(),
                TextColumn::make('tags_cache')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->formatStateUsing(
                        fn($state) =>
                        Tag::whereIn('id', is_array($state) ? $state : [$state])->pluck('name')->join(', ')
                    ),
                TextColumn::make('file_path')
                    ->label('Audio')
                    ->sortable()
                    ->toggleable() // allow toggle visibility
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
                    ->toggleable() // allow toggle visibility
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
                DeleteAction::make(),
                Action::make('download')
                    ->label('Download')
                    ->icon(Heroicon::ArrowDownCircle)
                    ->url(fn($record) => route('songs.download', $record))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function () {
                        Notification::make()
                            ->title('Download started')
                            ->success()
                            ->send();
                    }),

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

<?php

namespace App\Filament\Resources\Songs;

use App\Filament\Resources\Songs\Pages\CreateSong;
use App\Filament\Resources\Songs\Pages\EditSong;
use App\Filament\Resources\Songs\Pages\ListSongs;
use App\Filament\Resources\Songs\Schemas\SongForm;
use App\Filament\Resources\Songs\Tables\SongsTable;
use App\Models\Song;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::MusicalNote;

    protected static ?string $recordTitleAttribute = 'Song';

    //Permissions and Auth to resources
    public static function canCreate(): bool
    {
        return auth()->user()->can('create songs');
    }

    protected static function getTableRecordUrlUsing(): ?\Closure
    {
        return fn($record) =>
        auth()->user()->can('update', $record)
            ? static::getUrl('edit', ['record' => $record])
            : null;
    }


    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit songs');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete songs');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can('view songs');
    }

    // Optional: control navigation visibility
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view songs');
    }

    public static function form(Schema $schema): Schema
    {
        return SongForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SongsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSongs::route('/'),
            'create' => CreateSong::route('/create'),
            'edit' => EditSong::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

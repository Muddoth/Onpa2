<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use App\Models\User;
use App\Models\Artist;
use App\Models\Playlist;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Songs', Song::count()),
            Stat::make('Artists', Artist::count()),
            Stat::make('Playlists', Playlist::count()),
            Stat::make('Users', User::count()),
        ];
    }
}

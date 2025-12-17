<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Profile;
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
            Stat::make('Songs', Profile::count()),
            Stat::make('Songs', Playlist::count()),
        ];
    }
}

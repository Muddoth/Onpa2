<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use Filament\Widgets\Widget;

class MusicPlayer extends Widget
{
    protected ?string $heading = 'Music Player';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';


    // Use blade view instead of chart data
    protected string $view = 'filament.widgets.music-player';

    public $song;

    public function mount()
    {
        // For demo, load the first song or you can customize how to pick a song
        $this->song = Song::with('artist')->first();
    }
}


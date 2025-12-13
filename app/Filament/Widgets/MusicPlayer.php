<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use Filament\Widgets\Widget;

class MusicPlayer extends Widget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;


    protected ?string $heading = 'Music Player';
    protected string $view = 'filament.widgets.music-player';

    public $song;

    public function mount()
    {
        // For demo, load the first song or you can customize how to pick a song
        $this->song = Song::with('artist')->first();
    }
}

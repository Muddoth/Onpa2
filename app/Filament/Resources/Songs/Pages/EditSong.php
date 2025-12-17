<?php

namespace App\Filament\Resources\Songs\Pages;

use Filament\Facades\Filament;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Songs\SongResource;



class EditSong extends EditRecord
{

    protected static string $resource = SongResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        if (! auth()->user()->can('update', $this->record)) {
            Notification::make()
                ->title('Unauthorized')
                ->danger()
                ->body('You do not have permission to edit this song.')
                ->send();
                
            $panel = Filament::getCurrentPanel();
            $this->redirect($panel->getUrl() . '/songs');

            return; // ⬅️ IMPORTANT
        }
    }

    protected function getRedirectUrl(): string
    {
        $panel = Filament::getCurrentPanel();
        return $panel->getUrl() . '/songs';
    }
}

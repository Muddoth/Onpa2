<?php

//PERSONAL PROFILE PAGE PER LOGGED IN USER

namespace App\Filament\Pages;

use App\Models\User;
use InteractsWithForms;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use BackedEnum;


class Profile extends Page implements HasForms

{
    protected string $view = 'filament.pages.profile';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 50;

    public User $user;
    public bool $editing = false;

    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'user';
    }

    public function edit(): void
    {
        $this->editing = true;
        $this->form->fill($this->user->toArray());
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email(),
        ];
    }

    public function save(): void
    {
        $this->user->update($this->form->getState());
        $this->editing = false;
    }
    public function mount(): void
    {
        $this->user = auth()->user();
    }
}

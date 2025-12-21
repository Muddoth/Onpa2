<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Resources\Profiles\Schemas\ProfileForm;


class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.profile';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'My Profile';

public bool $editing = false;
    public $user;

    public function form(Schema $schema): Schema
    {
        return ProfileForm::configure($schema);
    }


    public function mount(): void
    {
        $this->user = auth()->user();
        $this->form->fill([
            'user_id'           => $this->user->id, // ✅ IMPORTANT
            'profile_picture'   => $this->user->profile?->profile_picture,
            'name'              => $this->user->profile?->name,
            'age'               => $this->user->profile?->age,
            'gender'            => $this->user->profile?->gender,
            'bio'               => $this->user->profile?->bio,
            'favourite_genres'  => $this->user->profile?->favourite_genres,
        ]);
    }

    public function edit(): void
    {
        $this->editing = true;
        $this->form->fill([
            'user_id'           => $this->user->id, // ✅ IMPORTANT
            'profile_picture'   => $this->user->profile?->profile_picture,
            'name'              => $this->user->profile?->name,
            'age'               => $this->user->profile?->age,
            'gender'            => $this->user->profile?->gender,
            'bio'               => $this->user->profile?->bio,
            'favourite_genres'  => $this->user->profile?->favourite_genres,
        ]);
    }

    public function cancel(): void
    {
        $this->editing = false;
    }


    public function save(): void
    {
        $this->form->validate();

        $data = $this->form->getState();
        $this->user->update($data);

        $this->editing = false;

        $this->notify('success', 'Profile updated successfully!');
    }
}

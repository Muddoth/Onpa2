<?php

namespace App\Filament\Pages;

use BackedEnum;
use App\Models\Tag;
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
    public array $data = [];


    public function form(Schema $schema): Schema
    {
        return ProfileForm::configure($schema)
            ->statePath('data');
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
        $data = $this->data;

        $this->user->profile()->updateOrCreate(
            ['user_id' => $this->user->id],
            [
                ...$data,
                'favourite_genres' => json_encode($data['favourite_genres'] ?? []),
            ]
        );

        $this->editing = false;

        $this->notify('success', 'Profile updated successfully!');
    }


    //numbers -> actual tag names
    public function getFavouriteGenresNamesProperty(): ?string
    {
        $state = $this->user->profile?->favourite_genres;

        if (!$state) {
            return null;
        }

        $tagIds = is_array($state) ? $state : json_decode($state, true);

        if (!is_array($tagIds)) {
            return null;
        }

        return Tag::whereIn('id', $tagIds)
            ->pluck('name')
            ->implode(', ');
    }
}

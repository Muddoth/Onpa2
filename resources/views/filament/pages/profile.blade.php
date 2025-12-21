<x-filament::page>
    <x-filament::section heading="My Profile">

        @if (!$editing)
            @php
                $profile = $user->profile;
            @endphp

            {{-- Profile Picture --}}
            @if ($profile?->profile_picture)
                <img src="{{ $profile->profile_picture }}" alt="Profile Picture"
                    style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; margin-bottom: 1rem;">
            @endif

            {{-- USER TABLE --}}
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            {{-- PROFILE TABLE --}}
            <p><strong>Age:</strong> {{ $profile?->age ?? '—' }}</p>
            <p><strong>Gender:</strong> {{ $profile?->gender ?? '—' }}</p>
            <p><strong>Bio:</strong> {{ $profile?->bio ?? '—' }}</p>
            <p><strong>Favourite Genres:</strong>
                {{ $profile?->favourite_genres ?? '—' }}
            </p>

            <x-filament::button wire:click="edit" class="mt-4">
                Edit Profile
            </x-filament::button>
        @else
            <form wire:submit.prevent="save">
                {{ $this->form }}

                <x-filament::button type="submit" class="mt-6">
                    Save
                </x-filament::button>

                <x-filament::button type="button" wire:click="cancel" color="secondary" class="mt-6 ml-2">
                    Cancel
                </x-filament::button>
            </form>
        @endif

    </x-filament::section>
</x-filament::page>

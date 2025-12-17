<x-filament::page>
    <x-filament::section heading="My Profile">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <x-filament::button wire:click="edit">
            Edit Profile
        </x-filament::button>
    </x-filament::section>
</x-filament::page>


<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Playlist;

class PlaylistPolicy
{
    public function viewAny(User $user): bool
    {
        // Users can view only their own playlists
        return true; // We will filter data in resource query (see later)
    }

    public function view(User $user, Playlist $playlist): bool
    {
        // User can view if they own the playlist
        return $playlist->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        // Allow users to create playlists
        return true;
    }

    public function update(User $user, Playlist $playlist): bool
    {
        // User can update only their own playlists
        return $playlist->user_id === $user->id;
    }

    public function delete(User $user, Playlist $playlist): bool
    {
        // User can delete only their own playlists
        return $playlist->user_id === $user->id;
    }
}

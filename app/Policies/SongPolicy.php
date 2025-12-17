<?php

namespace App\Policies;

use App\Models\Song;
use App\Models\User;

class SongPolicy
{
    public function view(User $user, Song $song)
    {
        return true; // Everyone can view songs
    }

    public function create(User $user)
    {
        return $user->can('create songs');
    }

    public function update(User $user, Song $song)
    {
        // Admin can edit any song
        if ($user->hasRole('admin')) {
            return true;
        }

        // Artist can only edit their own songs
        if (
            $user->hasRole('artist')
            && $user->can('edit songs')
            && $user->artist
        ) {
            return $song->artist_id === $user->artist->id;
        }
        return false;
    }

    public function delete(User $user, Song $song)
    {
        // Admin can delete any song
        if ($user->hasRole('admin')) {
            return true;
        }

        // Artist can only delete their own songs
        if (
            $user->hasRole('artist')
            && $user->can('delete songs')
            && $user->artist
        ) {
            return $song->artist_id === $user->artist->id;
        }

        return false;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view songs');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['name', 'profile_id', 'description'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}

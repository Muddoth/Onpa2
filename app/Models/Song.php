<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'artist_id',
        'album',
        'tags_cache',
        'file_path',
        'image_path'
    ];

    protected $casts = [
        'tags_cache' => 'array',
    ];



    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'song_tag');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function syncTagsCache()
    {
        $this->updateQuietly([
            'tags_cache' => $this->tags()->pluck('id')->toArray(),
        ]);
    }
}

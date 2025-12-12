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
        'artist',
        'album',
        'genre',
        'file_path',
        'image_path'
    ];

    protected $casts = [
        'genre' => 'array',
    ];

    public function scopeOfGenre($query, $genre)
    {
        if ($genre === 'all' || empty($genre)) {
            return $query;
        }

        // Use JSON_CONTAINS for MySQL JSON column to check if genre exists in JSON array
        return $query->whereJsonContains('genre', $genre);
    }

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
}

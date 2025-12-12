<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Song;
use App\Models\Artist;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        $audioFolder = public_path('audio');
        $imageFolder = public_path('images/songs');
        $faker = Faker::create();

        $artists = Artist::all();
        $tags = Tag::all();  // Get all tags

        $audioFiles = collect(scandir($audioFolder))
            ->filter(fn($f) => !in_array($f, ['.', '..']) && pathinfo($f, PATHINFO_EXTENSION) === 'mp3')
            ->values();

        $count = 0;

        foreach ($audioFiles as $audioFile) {
            $randomImages = collect(glob(public_path('images/songs/random/*.{jpg,jpeg,png,gif}'), GLOB_BRACE));
            // Extract the unique code after the last dash
            $fileNameWithoutExt = pathinfo($audioFile, PATHINFO_FILENAME);
            $parts = explode(' - ', $fileNameWithoutExt);
            $code = end($parts); // e.g. 8081721761877750
            $songName = $parts[0] ?? $fileNameWithoutExt;

            // Find matching image by code
            $imageMatch = collect(glob("$imageFolder/*$code.*"))->first();

            // Fallback if no matching image
            $imagePath = $imageMatch
                ? 'images/songs/' . basename($imageMatch)
                : 'images/songs/random/' . basename($randomImages->random());

            $artist = $artists->random();

            $song = Song::create([
                'name' => $songName,
                'artist_id' => $artist->id, // ✅ link song → artist
                'album' => $faker->words(2, true),
                'file_path' => 'audio/' . $audioFile,
                'image_path' => $imagePath,
            ]);

            // Attach 1-3 random tags to the song (many-to-many)
            $randomTags = $tags->random(rand(1, 3));
            $song->tags()->attach($randomTags->pluck('id'));


            $count++;
        }

        echo "$count songs seeded successfully!\n";
    }
}

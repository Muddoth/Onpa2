<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        // Find the test user by email
        $testUser = User::where('email', 'listener@example.com')->first();

        if (!$testUser) {
            echo "Test user not found. Please create the test user first.\n";
            return;
        }

        // Get the profile_id related to test user
        $profileId = $testUser->profile->id ?? null;

        if (!$profileId) {
            echo "Test user profile not found.\n";
            return;
        }

        // Define playlists for the test user's profile
        $playlists = [
            ['profile_id' => $profileId, 'name' => 'Chill Vibes', 'description' => 'Relaxing and mellow tracks.'],
            ['profile_id' => $profileId, 'name' => 'Workout Mix', 'description' => 'High-energy songs to stay pumped.'],
            ['profile_id' => $profileId, 'name' => 'Throwbacks', 'description' => 'Old-school hits and classics.'],
        ];

        foreach ($playlists as $data) {
            $playlist = Playlist::create($data);

            // Attach random songs (assuming songs already seeded)
            $songIds = Song::inRandomOrder()->take(rand(3, 8))->pluck('id');
            $playlist->songs()->attach($songIds);
        }

        echo "Playlists seeded successfully for test user!\n";
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Song;
use App\Models\Profile;

use Illuminate\Database\Seeder;
use Database\Seeders\SongSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserProfileSeeder::class,
            ArtistSeeder::class,
            TagSeeder::class,
            SongSeeder::class, 
            PlaylistSeeder::class
        ]);
         
    }
}

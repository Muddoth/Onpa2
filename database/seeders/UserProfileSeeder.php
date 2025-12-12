<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UserProfileSeeder extends Seeder
{
    public function run()
    {
        // Create admin
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword123'),
        ]);
        $adminUser->assignRole('admin');

        // Create artist
        $artistUser = User::create([
            'name' => 'Artist User',
            'email' => 'artist@example.com',
            'password' => bcrypt('artistpassword123'),
        ]);
        $artistUser->assignRole('artist');

        // Create listener
        $listenerUser = User::create([
            'name' => 'Listener User',
            'email' => 'listener@example.com',
            'password' => bcrypt('listenerpassword123'),
        ]);
        $listenerUser->assignRole('listener');

        //SPATIE_DIRECT PERMISSION
        // Assign a direct permission to a specific user
        $specialUser = User::firstWhere('email', 'listener@example.com');
        if ($specialUser) {
            $specialUser->givePermissionTo('create songs');
        }

        // Profiles for each
        foreach ([$adminUser, $artistUser, $listenerUser] as $user) {
            Profile::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }

        // Optional: create random users
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('listener'); // default role
            Profile::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        });
    }
}

<?php

namespace App\Providers;

use App\Models\Song;
use App\Models\Playlist;
use App\Policies\SongPolicy;
use App\Policies\PlaylistPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** 
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Song::class => SongPolicy::class,
        Playlist::class => PlaylistPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

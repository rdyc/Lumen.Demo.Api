<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->register_repositories();
    }

    private function register_repositories(){
        $this->app->bind('App\Repositories\Contracts\IArtistRepository', 'App\Repositories\ArtistRepository', true);
        $this->app->bind('App\Repositories\Contracts\IAlbumRepository', 'App\Repositories\AlbumRepository', true);
        $this->app->bind('App\Repositories\Contracts\ISongRepository', 'App\Repositories\SongRepository', true);
        $this->app->bind('App\Repositories\Contracts\IMasterGeneralRepository', 'App\Repositories\MasterGeneralRepository', true);
        
    }
}

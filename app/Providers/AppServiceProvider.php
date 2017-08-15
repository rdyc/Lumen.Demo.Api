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
        $this->register_services();
        $this->register_repositories();
    }

    private function register_services(){
        $this->app->bind(\App\Services\Contracts\ISyncService::class, \App\Services\SyncService::class, true);
    }

    private function register_repositories(){
        $this->app->bind(\App\Repositories\Contracts\IMasterGeneralRepository::class, \App\Repositories\MasterGeneralRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncRepository::class, \App\Repositories\SyncRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncClientRepository::class, \App\Repositories\SyncClientRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncStorageRepository::class, \App\Repositories\SyncStorageRepository::class, true);
    }
}

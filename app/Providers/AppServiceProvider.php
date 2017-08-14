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
        $this->app->bind('App\Services\Contracts\ISyncService', 'App\Services\SyncService', true);
    }

    private function register_repositories(){
        $this->app->bind('App\Repositories\Contracts\IMasterGeneralRepository', 'App\Repositories\MasterGeneralRepository', true);
        $this->app->bind('App\Repositories\Contracts\ISyncRepository', 'App\Repositories\SyncRepository', true);
        $this->app->bind('App\Repositories\Contracts\ISyncClientRepository', 'App\Repositories\SyncClientRepository', true);
    }
}

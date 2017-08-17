<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->queueOnBoot();
    }

    private function queueOnBoot()
    {
        Queue::before(function (JobProcessing $event) {
            $connection = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();

            Log::info('[Queue] Processing ' . $payload['displayName'] . ' With ID ' . $job->getJobId());
        });

        Queue::after(function (JobProcessed $event) {
            $connection = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();

            Log::info('[Queue] Completed ' . $payload['displayName'] . ' With ID ' . $job->getJobId());
        });

        Queue::failing(function (JobFailed $event) {
            $connection = $event->connectionName;
            $job = $event->job;
            $payload = $event->job->payload();

            Log::info('[Queue] Error ' . $payload['displayName'] . ' With ID ' . $job->getJobId());
        });

        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });
    }

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

    private function register_services()
    {
        $this->app->bind(\App\Services\Contracts\ISyncService::class, \App\Services\SyncService::class, true);
        $this->app->bind(\App\Services\Contracts\Synchronize\IMergeService::class, \App\Services\Synchronize\MergeService::class, true);
    }

    private function register_repositories()
    {
        $this->app->bind(\App\Repositories\Contracts\IMasterGeneralRepository::class, \App\Repositories\MasterGeneralRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncRepository::class, \App\Repositories\SyncRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncPushRepository::class, \App\Repositories\SyncPushRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncClientRepository::class, \App\Repositories\SyncClientRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncStoragePullRepository::class, \App\Repositories\SyncStoragePullRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\ISyncStoragePushRepository::class, \App\Repositories\SyncStoragePushRepository::class, true);
    }
}

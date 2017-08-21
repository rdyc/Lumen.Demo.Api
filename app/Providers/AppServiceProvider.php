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
        $this->app->bind(\App\Services\Contracts\Synchronize\ISyncManagerService::class, \App\Services\Synchronize\SyncManagerService::class, true);
        $this->app->bind(\App\Services\Contracts\Synchronize\ISyncMergeService::class, \App\Services\Synchronize\SyncMergeService::class, true);
    }

    private function register_repositories()
    {
        $this->app->bind(\App\Repositories\Contracts\IMasterGeneralRepository::class, \App\Repositories\MasterGeneralRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncPullRepository::class, \App\Repositories\Synchronize\SyncPullRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncPushRepository::class, \App\Repositories\Synchronize\SyncPushRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncClientRepository::class, \App\Repositories\Synchronize\SyncClientRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncStoragePullRepository::class, \App\Repositories\Synchronize\SyncStoragePullRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncStoragePushRepository::class, \App\Repositories\Synchronize\SyncStoragePushRepository::class, true);
    }
}

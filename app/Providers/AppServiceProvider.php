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
        $this->register_models();
        $this->register_repositories();

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
        $this->register_models();
        $this->register_services();
        $this->register_repositories();
    }

    private function register_models(){
        $this->app->make(\App\Models\SyncPullModel::class);
        $this->app->make(\App\Models\SyncPushModel::class);
        $this->app->make(\App\Models\SyncClientModel::class);
        $this->app->make(\App\Models\SyncStoragePullModel::class);
        $this->app->make(\App\Models\SyncStoragePushModel::class);

        $this->app->make(\App\Models\GeneralModel::class);
        $this->app->make(\App\Models\ElementFormModel::class);
        $this->app->make(\App\Models\ElementItemModel::class);
        $this->app->make(\App\Models\ElementMatrixModel::class);
        $this->app->make(\App\Models\ValidationRuleModel::class);
    }

    private function register_services()
    {
        $this->app->bind(\App\Services\Contracts\Synchronize\ISyncHelperService::class, \App\Services\Synchronize\SyncHelperService::class, true);
        $this->app->bind(\App\Services\Contracts\Synchronize\ISyncManagerService::class, \App\Services\Synchronize\SyncManagerService::class, true);
        $this->app->bind(\App\Services\Contracts\Synchronize\ISyncMergeService::class, \App\Services\Synchronize\SyncMergeService::class, true);
    }

    private function register_repositories()
    {
        $this->app->bind(\App\Repositories\Contracts\IGeneralRepository::class, \App\Repositories\GeneralRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\IElementFormRepository::class, \App\Repositories\ElementFormRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\IElementItemRepository::class, \App\Repositories\ElementItemRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\IElementMatrixRepository::class, \App\Repositories\ElementMatrixRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\IValidationRuleRepository::class, \App\Repositories\ValidationRuleRepository::class, true);

        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncPullRepository::class, \App\Repositories\Synchronize\SyncPullRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncPushRepository::class, \App\Repositories\Synchronize\SyncPushRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncClientRepository::class, \App\Repositories\Synchronize\SyncClientRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncStoragePullRepository::class, \App\Repositories\Synchronize\SyncStoragePullRepository::class, true);
        $this->app->bind(\App\Repositories\Contracts\Synchronize\ISyncStoragePushRepository::class, \App\Repositories\Synchronize\SyncStoragePushRepository::class, true);
    }
}

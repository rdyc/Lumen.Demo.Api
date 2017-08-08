<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ApiMakeCommand::class,
        \App\Console\Commands\RepositoryMakeCommand::class,
        \App\Console\Commands\RepositoryContractMakeCommand::class,
        \App\Console\Commands\RepositoryModelMakeCommand::class,
        \App\Console\Commands\ApiControllerMakeCommand::class,
        \App\Console\Commands\ApiPostRequestMakeCommand::class,
        \App\Console\Commands\ApiPatchRequestMakeCommand::class,
        \App\Console\Commands\ApiResponseMakeCommand::class,
        \App\Console\Commands\ApiResponseCollectionMakeCommand::class,
        \App\Console\Commands\ApiResponseItemMakeCommand::class,
        \App\Console\Commands\ApiTransformerMakeCommand::class,
        \App\Console\Commands\ApiTestMakeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}

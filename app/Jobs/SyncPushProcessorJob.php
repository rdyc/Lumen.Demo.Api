<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class SyncPushProcessorJob extends Job
{

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('push version '. $this->data['version']);
    }
}

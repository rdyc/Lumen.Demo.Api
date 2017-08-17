<?php

namespace App\Jobs;

use App\Services\Contracts\Synchronize\IMergeService;

class SyncPushProcessorJob extends Job
{

    /**
     * The number of seconds before the job should be made available.
     *
     * @var \DateTime|int|null
     */
    public $delay = 10;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;
    protected $data;
    protected $service;

    /**
     * Create a new job instance.
     *
     * @param IMergeService $mergeService
     * @param $data array
     */
    public function __construct(IMergeService $mergeService, $data)
    {
        $this->data = $data;
        $this->service = $mergeService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->start($this->data['version'], $this->data['path']);
    }
}

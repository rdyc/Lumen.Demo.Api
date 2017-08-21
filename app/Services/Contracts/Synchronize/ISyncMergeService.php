<?php

namespace App\Services\Contracts\Synchronize;


interface ISyncMergeService
{
    public function start($version, $path);
}
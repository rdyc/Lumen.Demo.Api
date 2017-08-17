<?php

namespace App\Services\Contracts\Synchronize;


interface IMergeService
{
    public function start($version, $path);
}
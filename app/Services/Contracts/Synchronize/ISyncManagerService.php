<?php

namespace App\Services\Contracts\Synchronize;

interface ISyncManagerService
{
    public function get($page, $limit, $order, $sort);

    public function latest($payload, $user);

    public function pull($payload, $user);

    public function push($payload, $user);

    public function track($user);

    public function getSyncedModels();
}
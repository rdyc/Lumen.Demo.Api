<?php

namespace App\Services\Contracts;

interface ISyncService
{
    public function get($page, $limit, $order, $sort);

    public function latest($payload, $user);

    public function pull($payload, $user);

    public function push($payload, $user);

    public function track($user);
}
<?php

namespace App\Services\Contracts;

interface ISyncService
{
    public function getLatest($attributes, $user);

    public function track($user);

    public function get($page, $limit, $order, $sort);

    public function findChanges($version, $user);
}
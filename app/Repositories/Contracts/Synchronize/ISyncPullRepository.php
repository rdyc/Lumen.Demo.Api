<?php

namespace App\Repositories\Contracts\Synchronize;

use App\Repositories\Contracts\IGenericRepository;

interface ISyncPullRepository extends IGenericRepository
{
    public function getLatest($client = null);

    public function count($date);

    public function store(array $attributes);

    public function getSince($version);
}
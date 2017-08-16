<?php

namespace App\Repositories\Contracts;

interface ISyncPushRepository extends IGenericRepository
{
    public function getLatest($client = null);

    public function count($date);

    public function store(array $attributes);

    public function getSince($version);
}
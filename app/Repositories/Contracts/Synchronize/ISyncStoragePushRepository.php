<?php

namespace App\Repositories\Contracts\Synchronize;

use App\Repositories\Contracts\IGenericRepository;

interface ISyncStoragePushRepository extends IGenericRepository
{
    public function getByVersion($version);
}
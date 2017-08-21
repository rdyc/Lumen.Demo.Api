<?php

namespace App\Repositories\Contracts\Synchronize;

use App\Repositories\Contracts\IGenericRepository;

interface ISyncStoragePullRepository extends IGenericRepository
{
    public function getByVersion($version);
}
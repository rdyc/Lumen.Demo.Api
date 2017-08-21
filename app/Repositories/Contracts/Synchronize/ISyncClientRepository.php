<?php

namespace App\Repositories\Contracts\Synchronize;

use App\Repositories\Contracts\IGenericRepository;

interface ISyncClientRepository extends IGenericRepository
{
    public function storeLog($attributes, $user);
}
<?php

namespace App\Repositories\Contracts;

interface ISyncClientRepository extends IGenericRepository
{
    public function storeLog($attributes, $user);
}
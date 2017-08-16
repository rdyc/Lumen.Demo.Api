<?php

namespace App\Repositories\Contracts;

interface ISyncStoragePullRepository extends IGenericRepository
{
    public function getByVersion($version);
}
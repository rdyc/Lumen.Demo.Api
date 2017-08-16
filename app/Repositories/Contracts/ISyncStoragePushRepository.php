<?php

namespace App\Repositories\Contracts;

interface ISyncStoragePushRepository extends IGenericRepository
{
    public function getByVersion($version);
}
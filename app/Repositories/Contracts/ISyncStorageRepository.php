<?php

namespace App\Repositories\Contracts;

interface ISyncStorageRepository extends IGenericRepository
{
    public function getByVersion($version);
}
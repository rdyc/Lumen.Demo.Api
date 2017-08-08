<?php

namespace App\Repositories\Contracts;

interface ISyncRepository extends IGenericRepository
{
    //
    public function getLatest();
}
<?php

namespace App\Repositories\Contracts;

interface IMasterGeneralRepository extends IGenericRepository
{

    public function all($carbon);
}
<?php

namespace App\Services\Contracts\Synchronize;

interface ISyncHelperService
{
    /**
     * Populate all synced model classes
     * @return null|array
     */
    public function populateModels();
}
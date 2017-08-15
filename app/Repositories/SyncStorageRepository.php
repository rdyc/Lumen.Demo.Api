<?php

namespace App\Repositories;

use App\Models\SyncStorageModel;
use App\Repositories\Contracts\ISyncStorageRepository;
use Illuminate\Support\Facades\App;

class SyncStorageRepository extends GenericRepository implements ISyncStorageRepository
{

    public function __construct()
    {
        parent::__construct(App::make(SyncStorageModel::class));
    }

    public function getByVersion($version)
    {
        return $this->model->where('sync_storage_version', $version)->firstOrFail();
    }
}
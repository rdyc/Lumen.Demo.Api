<?php

namespace App\Repositories\Synchronize;

use App\Models\SyncStoragePullModel;
use App\Repositories\Contracts\Synchronize\ISyncStoragePullRepository;
use App\Repositories\GenericRepository;
use Illuminate\Support\Facades\App;

class SyncStoragePullRepository extends GenericRepository implements ISyncStoragePullRepository
{

    public function __construct()
    {
        parent::__construct(App::make(SyncStoragePullModel::class));
    }

    public function getByVersion($version)
    {
        return $this->model->where('sync_storage_version', $version)->firstOrFail();
    }
}
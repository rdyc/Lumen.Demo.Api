<?php

namespace App\Repositories\Synchronize;

use App\Models\SyncStoragePushModel;
use App\Repositories\Contracts\Synchronize\ISyncStoragePushRepository;
use App\Repositories\GenericRepository;
use Illuminate\Support\Facades\App;

class SyncStoragePushRepository extends GenericRepository implements ISyncStoragePushRepository
{

    public function __construct()
    {
        parent::__construct(App::make(SyncStoragePushModel::class));
    }

    public function getByVersion($version)
    {
        return $this->model->where('sync_storage_version', $version)->firstOrFail();
    }
}
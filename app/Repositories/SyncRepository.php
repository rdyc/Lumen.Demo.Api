<?php

namespace App\Repositories;

use App\Models\SyncModel;
use App\Repositories\Contracts\ISyncRepository;
use Illuminate\Support\Facades\App;

class SyncRepository extends GenericRepository implements ISyncRepository
{

    public function __construct()
    {
        parent::__construct(App::make(SyncModel::class));
    }

    // define other methods here
    public function getLatest()
    {
        return $this->model->first();
    }
}
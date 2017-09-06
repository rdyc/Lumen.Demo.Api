<?php

namespace App\Repositories;

use App\Models\PemasokDetailItemModel;
use App\Repositories\Contracts\IPemasokDetailItemRepository;
use Illuminate\Support\Facades\App;

class PemasokDetailItemRepository extends GenericRepository implements IPemasokDetailItemRepository
{

    public function __construct()
    {
        parent::__construct(App::make(PemasokDetailItemModel::class));
    }

    // define other methods here
}

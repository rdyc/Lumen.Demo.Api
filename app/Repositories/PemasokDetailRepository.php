<?php

namespace App\Repositories;

use App\Models\PemasokDetailModel;
use App\Repositories\Contracts\IPemasokDetailRepository;
use Illuminate\Support\Facades\App;

class PemasokDetailRepository extends GenericRepository implements IPemasokDetailRepository
{

    public function __construct()
    {
        parent::__construct(App::make(PemasokDetailModel::class));
    }

    // define other methods here
}

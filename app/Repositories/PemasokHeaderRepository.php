<?php

namespace App\Repositories;

use App\Models\PemasokHeaderModel;
use App\Repositories\Contracts\IPemasokHeaderRepository;
use Illuminate\Support\Facades\App;

class PemasokHeaderRepository extends GenericRepository implements IPemasokHeaderRepository
{

    public function __construct()
    {
        parent::__construct(App::make(PemasokHeaderModel::class));
    }

    // define other methods here
}

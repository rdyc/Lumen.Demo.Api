<?php

namespace App\Repositories;

use App\Models\GeneralModel;
use App\Repositories\GenericRepository;
use App\Repositories\Contracts\IMasterGeneralRepository;
use Illuminate\Support\Facades\App;

class MasterGeneralRepository extends GenericRepository implements IMasterGeneralRepository
{

    public function __construct()
    {
        parent::__construct(App::make(GeneralModel::class));
    }

    // define other methods here
}

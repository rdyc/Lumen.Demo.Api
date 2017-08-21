<?php

namespace App\Repositories;

use App\Models\GeneralModel;
use App\Repositories\Contracts\IGeneralRepository;
use Illuminate\Support\Facades\App;

class GeneralRepository extends GenericRepository implements IGeneralRepository
{

    public function __construct()
    {
        parent::__construct(App::make(GeneralModel::class));
    }

    // define other methods here
}

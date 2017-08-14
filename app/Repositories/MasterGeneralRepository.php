<?php

namespace App\Repositories;

use App\Models\GeneralDataModel;
use App\Repositories\Contracts\IMasterGeneralRepository;
use Illuminate\Support\Facades\App;

class MasterGeneralRepository extends GenericRepository implements IMasterGeneralRepository
{

    public function __construct()
    {
        parent::__construct(App::make(GeneralDataModel::class));
    }

    // define other methods here
    /**
     * @param $carbon \Carbon\Carbon
     */
    public function all($carbon)
    {
        //return $this->model->where('updated_at', '>', $carbon ? $carbon->toDateString() : '1970-01-01')->get();
        return $this->model->get();
    }
}

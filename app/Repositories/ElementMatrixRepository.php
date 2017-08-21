<?php

namespace App\Repositories;

use App\Models\ElementMatrixModel;
use App\Repositories\Contracts\IElementMatrixRepository;
use Illuminate\Support\Facades\App;

class ElementMatrixRepository extends GenericRepository implements IElementMatrixRepository
{

    public function __construct()
    {
        parent::__construct(App::make(ElementMatrixModel::class));
    }
}

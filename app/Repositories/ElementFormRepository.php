<?php

namespace App\Repositories;

use App\Models\ElementFormModel;
use App\Repositories\Contracts\IElementFormRepository;
use Illuminate\Support\Facades\App;

class ElementFormRepository extends GenericRepository implements IElementFormRepository
{

    public function __construct()
    {
        parent::__construct(App::make(ElementFormModel::class));
    }

    // define other methods here
}

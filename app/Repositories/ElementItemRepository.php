<?php

namespace App\Repositories;

use App\Models\ElementItemModel;
use App\Repositories\Contracts\IElementItemRepository;
use Illuminate\Support\Facades\App;

class ElementItemRepository extends GenericRepository implements IElementItemRepository
{

    public function __construct()
    {
        parent::__construct(App::make(ElementItemModel::class));
    }
}

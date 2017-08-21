<?php

namespace App\Repositories;

use App\Models\ValidationRuleModel;
use App\Repositories\Contracts\IValidationRuleRepository;
use Illuminate\Support\Facades\App;

class ValidationRuleRepository extends GenericRepository implements IValidationRuleRepository
{

    public function __construct()
    {
        parent::__construct(App::make(ValidationRuleModel::class));
    }
}

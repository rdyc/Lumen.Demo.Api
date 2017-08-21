<?php

namespace App\Services\Synchronize;

use App\Models\BaseSyncModel;
use App\Services\Contracts\Synchronize\ISyncHelperService;

class SyncHelperService implements ISyncHelperService
{

    public function populateModels()
    {
        $result = null;

        // get all sync classes
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, BaseSyncModel::class)) {

                if (!is_array($result)) $result = [];

                $model = new $class;

                if (!array_key_exists($class, $result)){
                    $result[$model->getTable()] = [
                        'class' => $class,
                        'repository' => $model->getRepository(),
                        'key' => $model->getKeyName(),
                        'columns' => $model->getFillable()
                    ];
                }
            }
        }

        return $result;
    }
}
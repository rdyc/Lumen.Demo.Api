<?php

namespace App\Models;

use Carbon\Carbon;

abstract class BaseSyncModel extends BaseModel
{

    public function getRepository(){
        return $this->repository;
    }

    /**
     * @param $carbon \Carbon\Carbon
     * @return mixed
     */
    public function getChanges($carbon){
        $carbon = Carbon::parse($carbon);

        return $this->where('updated_at', '>', $carbon->toDateTimeString())
            ->orderBy('updated_at', 'asc')
            ->get();
    }
}

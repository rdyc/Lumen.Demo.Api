<?php

namespace App\Repositories\Contracts;

interface IGenericRepository
{
    public function get($page, $limit, $sort, $order);
    public function find($id);
    public function create($model);
    public function update($id, $model);
    public function delete($id);

    public function syncUpdateOrCreate($id, $model);
}
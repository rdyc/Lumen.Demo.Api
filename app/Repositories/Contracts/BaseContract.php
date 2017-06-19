<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function getAll($page, $limit);
    public function find($id);
    public function create($model);
    public function update($id, $model);
    public function delete($id);
}
<?php

namespace App\Repositories;

use App\Models\Artist;
use App\Repositories\Contracts\IArtistRepository;

class ArtistRepository implements IArtistRepository
{
    protected $model;

    function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function getAll($page, $limit)
    {
        $data = $this->model->query();

        /*$data->orWhere(function($q){
            $q->where('name','like', '%a%');
            //$q->where('name', ['Jane', 'Jerry']);
        });*/

        return $data->offset(($page - 1) * $page)->limit($limit)->paginate($limit);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($model)
    {
         $data = $this->model->create($model);

         return $data->onCreated();
    }

    public function update($id, $model)
    {
        $data = $this->model->findOrFail($id);
        $data->update($model);

        return $data->onUpdated();
    }

    public function delete($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();

        return $data->onDeleted();
    }
}

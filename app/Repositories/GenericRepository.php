<?php

namespace App\Repositories;

use App\Repositories\Contracts\IGenericRepository;

abstract class GenericRepository implements IGenericRepository
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function get($page, $limit, $sort = null, $order = null, $filter = null)
    {
        $sortBy = $sort ? $sort : $this->model->getKeyName();
        $orderBy = $order ? $order : $this->model->getSortDirection();

        $data = $this->model->query();

        if(is_array($filter)){
            $data->orWhere(function($q){
                foreach($filter as $key => $value){
                    $q->where($key, 'like', '%'.$value.'%');
                }
            });
        }
        
        return $data
            ->orderBy($sortBy, $orderBy)
            ->offset(($page - 1) * $page)
            ->limit($limit)
            ->paginate($limit);
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

    public function syncUpdateOrCreate($id = null, $model)
    {
        if ($id) {
            $data = $this->model->find($id);

            // remove creator if defined in sync
            if (array_key_exists('created_by', $model)) unset($model['created_by']);

            // update existing
            $data->update($model);
        } else {
            // add creator/updater if defined in sync
            //if (array_key_exists('created_by', $model)) $model['updated_by'] = $model['created_by'];

            // create a new
            $this->model->create($model);
        }
    }
}

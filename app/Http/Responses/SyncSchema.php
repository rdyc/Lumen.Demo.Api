<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncSchema"))
 */
class SyncSchema
{
    /**
     * @SWG\Property
     * @var string
     */
    public $name;

    /**
     * @SWG\Property
     * @var string
     */
    public $key;

    /**
     * @SWG\Property
     * @var string
     */
    public $class;

    /**
     * @SWG\Property
     * @var string
     */
    public $repository;

    /**
     * @SWG\Property
     * @var string[]
     */
    public $columns;

    public function __construct($name, $model)
    {
        $this->name = $name;
        $this->key = $model->key;
        $this->class = $model->class;
        $this->repository = $model->repository;
        $this->columns = $model->columns;
    }

    public function serialize(){
        return get_object_vars($this);
    }
}
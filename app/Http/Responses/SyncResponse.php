<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncResponse"))
 */
class SyncResponse extends BaseLog
{
    /**
     * @SWG\Property
     * @var int
     */
    public $id;

    /**
     * @SWG\Property
     * @var string
     */
    public $version;

    /**
     * @SWG\Property
     * @var string
     */
    public $source;

    /**
     * @SWG\Property
     * @var string
     */
    public $path;

    /**
     * @SWG\Property
     * @var integer
     */
    public $size;

    public function __construct($model)
    {
        $this->id = $model->id;
        $this->version = $model->version;
        $this->source = $model->source;
        $this->path = $model->path;
        $this->size = $model->size;
        $this->createdBy = $model->created_by;
        $this->createdAt = $model->created_at;
        $this->updatedBy = $model->updated_by;
        $this->updatedAt = $model->updated_at;
    }

    public function serialize(){
        return get_object_vars($this);
    }
}
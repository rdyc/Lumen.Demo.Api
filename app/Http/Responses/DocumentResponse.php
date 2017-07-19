<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="DocumentResponse"))
 */
class DocumentResponse extends BaseLog
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
    public $name;

    /**
     * @SWG\Property
     * @var string
     */
    public $mime;

    /**
     * @SWG\Property
     * @var int
     */
    public $size;

    /**
     * @SWG\Property
     * @var string
     */
    public $content;

    public function __construct($model)
    {
        $this->id = $model->document_id;
        $this->name = $model->document_name;
        $this->mime = $model->document_mime;
        $this->size = $model->document_size;
        $this->content = $model->document_content;
        $this->createdBy = $model->created_by;
        $this->createdAt = $model->created_at;
        $this->updatedBy = $model->updated_by;
        $this->updatedAt = $model->updated_at;
    }

    public function serialize(){
        return get_object_vars($this);
    }
}
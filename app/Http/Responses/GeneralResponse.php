<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="GeneralResponse"))
 */
class GeneralResponse extends BaseLog
{
    /**
     * @SWG\Property
     * @var string
     */
    public $code;

    /**
     * @SWG\Property
     * @var string
     */
    public $descCode;

    /**
     * @SWG\Property
     * @var string
     */
    public $desc;

    /**
     * @SWG\Property
     * @var string
     */
    public $icon;

    /**
     * @SWG\Property
     * @var integer
     */
    public $order;

    /**
     * @SWG\Property
     * @var boolean
     */
    public $isActive;

    public function __construct($model)
    {
        $this->code = $model->general_code;
        $this->descCode = $model->description_code;
        $this->desc = $model->description;
        $this->icon = $model->icon;
        $this->order = $model->sorting;
        $this->isActive = $model->fl_status;
        $this->createdBy = $model->created_by;
        $this->createdAt = $model->created_at;
        $this->updatedBy = $model->updated_by;
        $this->updatedAt = $model->updated_at;
    }

    public function serialize(){
        return get_object_vars($this);
        //return (array)$this;
    }
}
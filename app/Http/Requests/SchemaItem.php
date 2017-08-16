<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(@SWG\Xml(name="SchemaItem"))
 */
class SchemaItem
{
    /**
     * @SWG\Property
     * @var string
     */
    public $column;

    /**
     * @SWG\Property
     * @var string
     */
    public $value;

    function __construct($item = null)
    {
        if($item) {
            $this->column = $item->column;
            $this->value = property_exists($item, 'value') ? $item->value : null;
        }
    }
}
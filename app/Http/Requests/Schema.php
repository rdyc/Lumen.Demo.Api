<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(@SWG\Xml(name="Schema"))
 */
class Schema
{
    /**
     * @SWG\Property
     * @var string
     */
    public $name;

    /**
     * @SWG\Property
     * @var \App\Http\Requests\SchemaCollectionItem[]
     */
    public $rows;

    function __construct($object = null)
    {
        if($object){
            $this->name = $object->name;
            $this->rows = [];

            foreach ($object->rows as $row) {
                $this->rows[] = new SchemaCollectionItem($row);
            }
        }
    }
}
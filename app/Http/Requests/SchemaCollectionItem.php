<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(@SWG\Xml(name="SchemaCollectionItem"))
 */
class SchemaCollectionItem
{
    /**
     * @SWG\Property
     * @var \App\Http\Requests\SchemaItem[]
     */
    public $row;

    function __construct($rows = null)
    {
        if($rows){
            $this->row = [];

            foreach ($rows as $row) {
                foreach ($row as $item) {
                    $this->row[] = new SchemaItem($item);
                }
            }
        }
    }
}
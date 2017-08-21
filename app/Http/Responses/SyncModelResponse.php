<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncModelResponse"))
 */
class SyncModelResponse
{
    /**
     * @SWG\Property
     * @var integer
     */
    public $total;

    /**
     * @SWG\Property
     * @var SyncSchema[]
     */
    public $schemas;

    public function __construct($attributes)
    {

        $schemas = [];
        foreach ($attributes as $key => $value) {
            $schema = new SyncSchema($key, $value);

            $schemas[] = $schema->serialize();
        }

        $this->schemas = $schemas;
        $this->total = count($this->schemas);
    }

    public function serialize()
    {
        return get_object_vars($this);
    }
}


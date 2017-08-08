<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="BaseCollection"))
 */
class BaseCollection
{
    /**
     * @SWG\Property
     * @var BaseMetadata
     */
    public $meta;
}
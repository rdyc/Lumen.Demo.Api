<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="GeneralCollectionResponse"))
 */
class GeneralCollectionResponse extends BaseCollection
{
    /**
     * @SWG\Property
     * @var GeneralResponse[]
     */
    protected $data;
}
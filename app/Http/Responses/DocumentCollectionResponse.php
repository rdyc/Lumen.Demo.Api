<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="DocumentCollectionResponse"))
 */
class DocumentCollectionResponse extends BaseCollection
{
    /**
     * @SWG\Property
     * @var DocumentResponse[]
     */
    protected $data;
}
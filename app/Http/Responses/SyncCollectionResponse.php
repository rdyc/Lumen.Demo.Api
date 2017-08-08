<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncCollectionResponse"))
 */
class SyncCollectionResponse extends BaseCollection
{
    /**
     * @SWG\Property
     * @var SyncResponse[]
     */
    protected $data;
}
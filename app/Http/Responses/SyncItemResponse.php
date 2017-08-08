<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncItemResponse"))
 */
class SyncItemResponse
{
    /**
     * @SWG\Property
     * @var SyncResponse
     */
    protected $data;
}
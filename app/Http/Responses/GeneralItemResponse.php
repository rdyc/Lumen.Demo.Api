<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="GeneralItemResponse"))
 */
class GeneralItemResponse
{
    /**
     * @SWG\Property
     * @var GeneralResponse
     */
    protected $data;
}
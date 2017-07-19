<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="DocumentItemResponse"))
 */
class DocumentItemResponse
{
    /**
     * @SWG\Property
     * @var DocumentResponse
     */
    protected $data;
}
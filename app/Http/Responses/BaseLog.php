<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="BaseLog"))
 */
class BaseLog
{
    /**
     * @SWG\Property
     * @var string
     */
    public $createdBy;

    /**
     * @SWG\Property
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @SWG\Property
     * @var string
     */
    public $updatedBy;

    /**
     * @SWG\Property
     * @var \DateTime
     */
    public $updatedAt;
}
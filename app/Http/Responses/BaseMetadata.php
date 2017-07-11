<?php

namespace App\Http\Responses;

/**
 * @SWG\Definition(@SWG\Xml(name="BaseMetadata"))
 */
class BaseMetadata
{
    /**
     * @SWG\Property
     * @var integer
     */
    public $total;

    /**
     * @SWG\Property
     * @var integer
     */
    public $limit;

    /**
     * @SWG\Property
     * @var integer
     */
    public $page;

    /**
     * @SWG\Property
     * @var integer
     */
    public $from;

    /**
     * @SWG\Property
     * @var integer
     */
    public $to;
}
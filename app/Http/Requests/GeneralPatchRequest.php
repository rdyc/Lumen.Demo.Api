<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="GeneralPatchRequest"))
 */
class GeneralPatchRequest
{
    protected $validator;

    /**
     * @SWG\Property
     * @var string
     */
    protected $descCode;

    /**
     * @SWG\Property
     * @var string
     */
    protected $desc;

    /**
     * @SWG\Property
     * @var string
     */
    protected $icon;

    /**
     * @SWG\Property
     * @var integer
     */
    protected $order;

    /**
     * @SWG\Property
     * @var boolean
     */
    protected $isActive;

    public function __construct($payload)
    {
        if (empty($payload)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Request payload was empty');
        }

        $this->validator = Validator::make($payload, [
            'descCode' => 'string|max:255',
            'desc' => 'string|max:1000',
            'icon' => 'string',
            'order' => 'integer',
            'isActive' => 'boolean'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map((object)$payload);
    }

    private function map($object)
    {
        $this->descCode = property_exists($object, 'descCode') ? $object->descCode : null;
        $this->desc = property_exists($object, 'desc') ? $object->desc : null;
        $this->order = property_exists($object, 'order') ? (int)$object->order : null;
        $this->isActive = property_exists($object, 'isActive') ? (bool)$object->isActive : null;
    }

    public function parse()
    {
        $result = array(
            'description_code' => $this->descCode,
            'description' => $this->desc,
            'sorting' => $this->order,
            'fl_status' => $this->isActive
        );

        return array_filter($result, 'strlen');
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="GeneralPostRequest"))
 */
class GeneralPostRequest
{
    protected $validator;

    /**
     * @SWG\Property
     * @var string
     */
    protected $code;

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
        $this->validator = Validator::make($payload, [
            'code' => 'required|string|max:255|unique:tm_general_data,general_code',
            'descCode' => 'required|string|max:255',
            'desc' => 'required|string|max:1000',
            'icon' => 'string',
            'order' => 'required|integer',
            'isActive' => 'required|boolean'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map((object)$payload);
    }

    private function map($object)
    {
        $this->code = $object->code;
        $this->descCode = $object->descCode;
        $this->desc = $object->desc;
        $this->order = (int)$object->order;
        $this->isActive = (bool)$object->isActive;
    }

    public function parse()
    {
        return [
            'general_code' => $this->code,
            'description_code' => $this->descCode,
            'description' => $this->desc,
            'sorting' => $this->order,
            'fl_status' => $this->isActive
        ];
    }
}

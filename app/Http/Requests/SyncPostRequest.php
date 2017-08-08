<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncPostRequest"))
 */
class SyncPostRequest
{
    protected $validator;

    /**
     * @SWG\Property
     * @var string
     */
    protected $code;

    public function __construct($payload)
    {
        $this->validator = Validator::make($payload, [
            'code' => 'required|string|max:255'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map((object)$payload);
    }

    private function map($object)
    {
        $this->code = $object->code;
    }

    public function parse()
    {
        return [
            'column_code' => $this->code
        ];
    }
}

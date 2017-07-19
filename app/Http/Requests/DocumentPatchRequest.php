<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="DocumentPatchRequest"))
 */
class DocumentPatchRequest
{
    protected $validator;

    /**
     * @SWG\Property
     * @var code
     */
    protected $code;

    public function __construct($payload)
    {
        if (empty($payload)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Request payload was empty');
        }

        $this->validator = Validator::make($payload, [
            'code' => 'string|max:255',
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map((object)$payload);
    }

    private function map($object)
    {
        $this->code = property_exists($object, 'code') ? $object->code : null;
    }

    public function parse()
    {
        $result = [
            'column_code' => $this->code
        ];

        return array_filter($result, 'strlen');
    }
}

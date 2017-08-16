<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncPostRequest"))
 */
class SyncPostRequest extends Sync
{
    protected $validator;

    /**
     * @SWG\Property
     * @var \App\Http\Requests\Schema[]
     */
    public $schemas;

    /**
     * SyncPostRequest constructor.
     * @param $payload
     * @throws ValidationException
     * @return SyncPostRequest
     */
    public function __construct($payload)
    {
        $this->validator = Validator::make($payload, [
            'client' => 'required|string|max:255|exists:sync_client,sync_client_identifier',
            'version' => 'string|max:255|nullable|exists:sync,sync_version',
            'schemas' => 'required|array',
            'schemas.*.name' => 'required|string',
            'schemas.*.rows' => 'required|array',
            'schemas.*.rows.*.row' => 'required|array',
            'schemas.*.rows.*.row.*.column' => 'required|string',
            'schemas.*.rows.*.row.*.value' => 'nullable'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map(json_decode(json_encode($payload)));

        return $this;
    }

    private function map($object)
    {
        $this->version = $object->version;
        $this->client = $object->client;


        foreach ($object->schemas as $schema) {
            if(!is_array($this->schemas)) $this->schemas = [];

            $this->schemas[] = new Schema($schema);
        }
    }

    public function parse()
    {
        return [
            //'column_code' => $this->code
        ];
    }
}

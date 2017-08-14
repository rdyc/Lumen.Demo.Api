<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncRequest"))
 */
class SyncRequest
{
    protected $validator;

    /**
     * @SWG\Property(
     *     title="client",
     *     description="Client or device identifier",
     *     type="string"
     * )
     * @var string
     */
    public $client;

    /**
     * @SWG\Property(
     *     title="version",
     *     description="Client or device current version",
     *     type="string"
     * )
     * @var string
     */
    public $version;

    public function __construct($payload)
    {
        $this->validator = Validator::make($payload, [
            'client' => 'required|string|max:255',
            'version' => 'string|max:255|nullable|exists:sync,sync_version'
        ]);

        if ($this->validator->fails()) {
            throw new ValidationException($this->validator, $this->validator->errors());
        }

        $this->map((object)$payload);
    }

    private function map($object)
    {
        $this->version = $object->version;
        $this->client = $object->client;
    }

    public function parse()
    {
        return [
            'sync_client_identifier' => $this->client,
            'sync_client_version' => $this->version,
        ];
    }
}

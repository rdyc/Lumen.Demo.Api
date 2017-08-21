<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncPullRequest"))
 */
class SyncPullRequest extends Sync
{
    protected $validator;

    public function __construct($payload)
    {
        $this->validator = Validator::make($payload, [
            'client' => 'required|string|max:255',
            'version' => 'string|max:255|nullable|exists:sync_pull,sync_version'
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

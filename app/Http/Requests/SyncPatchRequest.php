<?php

namespace App\Http\Requests;

use App\Services\Contracts\Synchronize\ISyncHelperService;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * @SWG\Definition(@SWG\Xml(name="SyncPatchRequest"))
 */
class SyncPatchRequest extends Sync
{
    /**
     * @SWG\Property
     * @var \App\Http\Requests\Schema[]
     */
    public $schemas;

    protected $validator;

    /**
     * SyncPostRequest constructor.
     *
     * @param $payload
     * @param ISyncHelperService $helperService
     * @throws ValidationException
     */
    public function __construct($payload, ISyncHelperService $helperService)
    {
        $classes = $helperService->populateModels(); //print_r($classes);exit;

        $this->validator = Validator::make($payload, [
            'client' => 'required|string|max:255|exists:sync_client,sync_client_identifier',
            'version' => 'required|string|max:255|exists:sync_pull,sync_version',
            'schemas' => 'required|array',
            'schemas.*.name' => 'required|string|in:'. implode(',', array_keys($classes)),
            'schemas.*.rows' => 'required_with:schemas.*.name|array',
            'schemas.*.rows.*.row' => 'required_with:schemas.*.name|array',
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

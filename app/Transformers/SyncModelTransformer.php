<?php

namespace App\Transformers;

use App\Http\Responses\SyncModelResponse;
use League\Fractal\TransformerAbstract;

class SyncModelTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($model)
    {
        $response = new SyncModelResponse($model);

        return $response->serialize();
    }

}
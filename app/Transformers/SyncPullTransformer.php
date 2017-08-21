<?php

namespace App\Transformers;

use App\Http\Responses\SyncResponse;
use App\Models\SyncPullModel;
use League\Fractal\TransformerAbstract;

class SyncPullTransformer extends TransformerAbstract
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
    public function transform(SyncPullModel $model)
    {
        $response = new SyncResponse($model);

        return $response->serialize();
    }

}
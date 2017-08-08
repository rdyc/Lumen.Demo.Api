<?php

namespace App\Transformers;

use App\Http\Responses\SyncResponse;
use App\Models\SyncModel;
use Illuminate\Support\Facades\App;
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
    public function transform(SyncModel $model)
    {
        $response = new SyncResponse($model);

        return $response->serialize();
    }

}
<?php

namespace App\Transformers;

use App\Http\Responses\DocumentResponse;
use App\Models\DocumentModel;
use Illuminate\Support\Facades\App;
use League\Fractal\TransformerAbstract;

class DocumentModelTransformer extends TransformerAbstract
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
    public function transform(DocumentModel $model)
    {
        $response = new DocumentResponse($model);

        return $response->serialize();
    }

}
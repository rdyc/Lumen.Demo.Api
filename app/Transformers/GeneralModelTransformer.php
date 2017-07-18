<?php

namespace App\Transformers;

use App\Http\Responses\GeneralResponse;
use App\Models\GeneralModel;
use Illuminate\Support\Facades\App;
use League\Fractal\TransformerAbstract;

class GeneralModelTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        // no includes!
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(GeneralModel $model)
    {
        /*return [
            'code' => $model->general_code,
            'descCode' => $model->description_code,
            'desc' => $model->description,
            'icon' => $model->icon,
            'order' => $model->sorting,
            'isActive' => $model->fl_status,
            'createdBy' => $model->created_by,
            'createdAt' => $model->created_at,
            'updatedBy' => $model->updated_by,
            'updatedAt' => $model->updated_at
        ];*/

        $response = new GeneralResponse($model);

        return $response->serialize();
    }

}
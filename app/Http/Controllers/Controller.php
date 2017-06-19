<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

class Controller extends BaseController
{
    /**
     * Create the response for an item.
     *
     * @param  mixed $item
     * @param  TransformerAbstract $transformer
     * @param  string $include
     * @param  int $status
     * @param  array $headers
     * @return Response
     */
    protected function buildItemResponse($item, TransformerAbstract $transformer, $include = null, $status = 200, array $headers = [])
    {
        $resource = new Item($item, $transformer);

        return $this->buildResourceResponse($resource, $include, $status, $headers);
    }

    /**
     * Create the response for a resource.
     *
     * @param  ResourceAbstract $resource
     * @param  string $include
     * @param  int $status
     * @param  array $headers
     * @return Response
     */
    protected function buildResourceResponse(ResourceAbstract $resource, $include = null, $status = 200, array $headers = [])
    {
        $fractal = new \League\Fractal\Manager;

        if (!empty($include))
            $fractal->parseIncludes($include);

        return response()->json(
            $fractal->createData($resource)->toArray(),
            $status,
            $headers
        );
    }


    /**
     * Create the response for a collection.
     *
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param null $include
     * @param Cursor|null $cursor
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function buildCollectionResponse($collection, TransformerAbstract $transformer, $include = null, $status = 200, array $headers = [])
    {
        $resource = new Collection($collection, $transformer);
        $resource->setMeta([
            'total' => $collection->total(),
            'limit' => (int)$collection->perPage(),
            'page' => $collection->currentPage(),
            'from' => $collection->firstItem(),
            'to' => $collection->lastItem(),
        ]);

        return $this->buildResourceResponse($resource, $include, $status, $headers);
    }
}
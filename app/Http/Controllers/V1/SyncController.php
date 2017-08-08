<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncPatchRequest;
use App\Http\Requests\SyncPostRequest;
use App\Repositories\Contracts\ISyncRepository;
use App\Transformers\SyncModelTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SyncController extends Controller
{

    /**
     * @var \App\Repositories\Contracts\ISyncRepository
     */
    private $repo;

    public function __construct(ISyncRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/sync",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Get all syncs",
     *   description="",
     *   operationId="getAllSync",
     *   produces={"application/json"},
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Parameter(ref="#/parameters/Pagination.Page"),
     *   @SWG\Parameter(ref="#/parameters/Pagination.Limit"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="order",
     *     type="string",
     *     description="Ordered column",
     *     required=false,
     *     enum={"created_at"}
     *   ),
     *   @SWG\Parameter(ref="#/parameters/Sorting"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/SyncCollectionResponse")
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function get()
    {
        try {
            $page = Input::get('page', 1);
            $limit = Input::get('limit', 10);
            $order = Input::get('order');
            $sort = Input::get('sort');

            $items = $this->repo->get($page, $limit, $order, $sort);

            if ($items) {
                return $this->buildCollectionResponse($items, new SyncModelTransformer);
            } else {
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Get(path="/sync/{version}/files",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Get sync file",
     *   description="",
     *   operationId="getSyncFile",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="version",
     *     type="string",
     *     description="Sync Version",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/SyncItemResponse")
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function getId($version)
    {
        try {
            $item = $this->repo->find($version);

            return $this->buildItemResponse($item, new SyncModelTransformer);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Get(path="/sync/latest",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Get latest sync",
     *   description="",
     *   operationId="getLatestSync",
     *   produces={"application/json"},
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/SyncItemResponse")
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function getLatest()
    {
        try {
            $item = $this->repo->getLatest();

            return $item ? $this->buildItemResponse($item, new SyncModelTransformer) : response(null, Response::HTTP_NO_CONTENT);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/sync",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Creating sync",
     *   description="",
     *   operationId="createSync",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Sync data",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/SyncPostRequest")
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=201, ref="#/responses/Created"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function post(Request $request)
    {
        try {
            $post = new SyncPostRequest($request->all());

            $model = $post->parse();

            $updated = $this->repo->create($model);

            return response($updated, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}

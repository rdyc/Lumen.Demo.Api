<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncPatchRequest;
use App\Http\Requests\SyncPostRequest;
use App\Http\Requests\SyncRequest;
use App\Models\SyncClientModel;
use App\Repositories\Contracts\ISyncClientRepository;
use App\Repositories\Contracts\ISyncRepository;
use App\Services\Contracts\ISyncService;
use App\Transformers\SyncModelTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SyncController extends Controller
{

    /**
     * @var \App\Services\Contracts\ISyncService
     */
    protected $service;

    public function __construct(ISyncService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(path="/sync",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="All changes",
     *   description="",
     *   operationId="getAll",
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

            $items = $this->service->get($page, $limit, $order, $sort);

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
     * @SWG\Post(path="/sync/latest",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Check latest",
     *   description="",
     *   operationId="getLatestSync",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Sync data",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/SyncRequest")
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
    public function latest()
    {
        try {
            $user = (object)Auth::user();

            $payload = new SyncRequest(Input::all());

            $latest = $this->service->getLatest($payload->parse(), $user);
            //print_r($latest);exit;

            return response()->json($latest);

            //return $latest ? $this->buildCollectionResponse($latest, new SyncModelTransformer) : response(null, Response::HTTP_NO_CONTENT);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/sync/pull",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Pull changes",
     *   description="",
     *   operationId="syncPull",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Sync data",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/SyncRequest")
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
    public function pull()
    {
        try {
            $user = (object)Auth::user();

            $payload = new SyncRequest(Input::all());

            //$sync = $this->service->getLatest($payload->parse(), $user);
            $sync = $this->service->findChanges($payload->version, $user);
            //print_r($sync);exit;

            if($sync){
                return response()->json($sync);
            }else{
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getResponse());
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/sync/push",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Push client changes",
     *   description="",
     *   operationId="syncPush",
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
    public function push()
    {
        try {
            $post = new SyncPostRequest(Input::all());

            $model = $post->parse();

            $updated = $this->syncRepository->create($model);

            return response($updated, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/sync/track",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Sync"},
     *   summary="Track changes",
     *   description="",
     *   operationId="syncTrack",
     *   produces={"application/json"},
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=201, ref="#/responses/Accepted"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function track()
    {
        try {
            $user = (object)Auth::user();

            $track = $this->service->track($user);

            return response($track, $track ? Response::HTTP_ACCEPTED : Response::HTTP_NOT_MODIFIED);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\V1\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralPatchRequest;
use App\Http\Requests\GeneralPostRequest;
use App\Repositories\Contracts\IMasterGeneralRepository;
use App\Transformers\GeneralModelTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GeneralController extends Controller
{

    /**
     * @var \App\Repositories\Contracts\IMasterGeneralRepository
     */
    private $repo;

    public function __construct(IMasterGeneralRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/general",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Master General"},
     *   summary="Get all general data",
     *   description="",
     *   operationId="getAllGeneral",
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
     *     enum={"general_code", "description_code", "description"}
     *   ),
     *   @SWG\Parameter(ref="#/parameters/Sorting"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/GeneralCollectionResponse")
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

            $item = $this->repo->get($page, $limit, $order, $sort);

            if ($item) {
                return $this->buildCollectionResponse($item, new GeneralModelTransformer);
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
     * @SWG\Get(path="/general/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Master General"},
     *   summary="Get general data",
     *   description="",
     *   operationId="getGeneral",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Artist id",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/GeneralItemResponse")
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function getId($id)
    {
        try {
            $item = $this->repo->find($id);

            return $this->buildItemResponse($item, new GeneralModelTransformer);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/general",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Master General"},
     *   summary="Create general data",
     *   description="",
     *   operationId="createGeneral",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="General data",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/GeneralPostRequest")
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
            $post = new GeneralPostRequest($request->all());

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

    /**
     * @SWG\Patch(path="/general/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Master General"},
     *   summary="Update general data",
     *   description="",
     *   operationId="updateGeneral",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="General Code",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="General",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/GeneralPatchRequest")
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=202, ref="#/responses/Accepted"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function patch($id, Request $request)
    {
        try {
            $patch = new GeneralPatchRequest($request->all());

            $model = $patch->parse();

            $updated = $this->repo->update($id, $model);

            return response($updated, Response::HTTP_ACCEPTED);
        } catch (ValidationException $e) {
            return $e->response;
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Delete(path="/general/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Master General"},
     *   summary="Remove general data",
     *   description="",
     *   operationId="deleteGeneral",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="General Code",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=202, ref="#/responses/Deleted"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function delete($id)
    {
        try {
            // statements goes here
            $deleted = $this->repo->delete($id);

            return response($deleted, Response::HTTP_ACCEPTED);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}

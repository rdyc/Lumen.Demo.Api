<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ISongRepository;
use App\Transformers\SongTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Pagination\Cursor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TrackController extends Controller
{
    /**
    * @var \App\Repositories\Contracts\ISongRepository
    */
    private $repo;

    public function __construct(ISongRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/track",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Track"},
     *   summary="Get all Tracks",
     *   description="",
     *   operationId="getAllTracks",
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
     *     enum={"id", "title", "released", "updated_at"}
     *   ),
     *   @SWG\Parameter(ref="#/parameters/Sorting"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="include",
     *     type="array",
     *     description="Includes relationship",
     *     required=false,
     *     items={"artist", "album"},
     *     collectionFormat="csv",
     *     enum={"artist", "album"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/track"))
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function get()
    {
        try{
            $include = Input::get('include');
            $page = Input::get('page', 1);
            $limit = Input::get('limit', 10);
            $order = Input::get('order');
            $sort = Input::get('sort');

            $item = $this->repo->get($page, $limit, $order, $sort);

            if($item){
                return $this->buildCollectionResponse($item, new SongTransformer, $include);
            }else{
                return response(null, Response::HTTP_NO_CONTENT);
            }
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }


    /**
     * @SWG\Get(path="/track/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Track"},
     *   summary="Get Track",
     *   description="",
     *   operationId="getTrack",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Track id",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="include",
     *     type="array",
     *     description="Includes relationship",
     *     required=false,
     *     items={"Tracks", "album"},
     *     collectionFormat="csv",
     *     enum={"Tracks", "album"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/track"))
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function getId($id)
    {
        try{
            $include = Input::get('include', null);

            $item = $this->repo->find($id);

            return $this->buildItemResponse($item, new SongTransformer, $include);
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch(ModelNotFoundException $e){
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/track",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Track"},
     *   summary="Create Track",
     *   description="",
     *   operationId="createTrack",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Track",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/track")
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
        try{
            // statements goes here
            $this->validate($request, [
                'track' => 'required|int',
                'title' => 'required|string|max:50',
                'album_id' => 'required|int',
                'active' => 'required|boolean'
            ]);

            $model = $request->all();

            $updated = $this->repo->create($model);

            return response($updated, Response::HTTP_CREATED);
        }catch (ValidationException $e){
            return $e->response;
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Patch(path="/track/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Track"},
     *   summary="Update Track",
     *   description="",
     *   operationId="updateTrack",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Track id",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Track",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/track")
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
        try{
            // statements goes here
            $this->validate($request, [
                'track' => 'int',
                'title' => 'string|max:50',
                'album_id' => 'int',
                'active' => 'boolean'
            ]);

            $model = $request->all();

            if(empty($model)){
                throw new HttpException(Response::HTTP_BAD_REQUEST, 'No properties found');
            }

            $updated = $this->repo->update((int) $id, $model);

            return response($updated, Response::HTTP_ACCEPTED);
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch(ModelNotFoundException $e){
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Delete(path="/track/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Track"},
     *   summary="Remove Track",
     *   description="",
     *   operationId="deleteTrack",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Track id",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=202, ref="#/responses/Accepted"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function delete($id)
    {
        try{
            // statements goes here
            $deleted = $this->repo->delete((int) $id);

            return response($deleted, Response::HTTP_ACCEPTED);
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch(ModelNotFoundException $e){
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

}
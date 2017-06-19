<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IAlbumRepository;
use App\Transformers\AlbumTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Pagination\Cursor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AlbumController extends Controller
{
    /**
    * @var \App\Repositories\Contracts\IAlbumRepository
    */
    private $repo;

    public function __construct(IAlbumRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/album",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Album"},
     *   summary="Get all Albums",
     *   description="",
     *   operationId="getAllAlbums",
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
     *     items={"artist", "songs"},
     *     collectionFormat="csv",
     *     enum={"artist", "songs"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Album"))
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
                return $this->buildCollectionResponse($item, new AlbumTransformer, $include);
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
     * @SWG\Get(path="/album/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Album"},
     *   summary="Get Album",
     *   description="",
     *   operationId="getAlbum",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Album id",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="include",
     *     type="array",
     *     description="Includes relationship",
     *     required=false,
     *     items={"albums", "songs"},
     *     collectionFormat="csv",
     *     enum={"albums", "songs"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Album"))
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

            return $this->buildItemResponse($item, new AlbumTransformer, $include);
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch(ModelNotFoundException $e){
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/album",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Album"},
     *   summary="Create Album",
     *   description="",
     *   operationId="createAlbum",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Album",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Album")
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
                'name' => 'required|string|max:50',
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
     * @SWG\Patch(path="/album/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Album"},
     *   summary="Update Album",
     *   description="",
     *   operationId="updateAlbum",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Album id",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Album",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Album")
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
                'name' => 'string|max:50',
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
     * @SWG\Delete(path="/album/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Album"},
     *   summary="Remove Album",
     *   description="",
     *   operationId="deleteAlbum",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Album id",
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
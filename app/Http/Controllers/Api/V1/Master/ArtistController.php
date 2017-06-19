<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IArtistRepository;
use App\Transformers\ArtistTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Pagination\Cursor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ArtistController extends Controller
{
    /**
    * @var \App\Repositories\Contracts\IArtistRepository
    */
    private $repo;

    public function __construct(IArtistRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/artist",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Artist"},
     *   summary="Get all artists",
     *   description="",
     *   operationId="getAllArtists",
     *   produces={"application/json"},
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Parameter(ref="#/parameters/Pagination.Page"),
     *   @SWG\Parameter(ref="#/parameters/Pagination.Limit"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="include",
     *     type="array",
     *     description="Includes relationship",
     *     required=false,
     *     items={"albums", "albums.songs", "songs", "songs.album"},
     *     collectionFormat="csv",
     *     enum={"albums", "albums.songs", "songs", "songs.album"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Artist"))
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
            $include = Input::get('include', null);
            $page = Input::get('page', 1);
            $limit = Input::get('limit', 10);

            $item = $this->repo->getAll($page, $limit);

            if($item){
                return $this->buildCollectionResponse($item, new ArtistTransformer, $include);
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
     * @SWG\Get(path="/artist/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Artist"},
     *   summary="Get artist",
     *   description="",
     *   operationId="getArtist",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Artist id",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="include",
     *     type="array",
     *     description="Includes relationship",
     *     required=false,
     *     items={"albums", "albums.songs", "songs", "songs.album"},
     *     collectionFormat="csv",
     *     enum={"albums", "albums.songs", "songs", "songs.album"}
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Artist"))
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

            return $this->buildItemResponse($item, new ArtistTransformer, $include);
        }catch (HttpException $e){
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        }catch(ModelNotFoundException $e){
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/artist",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Artist"},
     *   summary="Create artist",
     *   description="",
     *   operationId="createArtist",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Artist",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Artist")
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
     * @SWG\Patch(path="/artist/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Artist"},
     *   summary="Update artist",
     *   description="",
     *   operationId="updateArtist",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Artist id",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Artist",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Artist")
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
     * @SWG\Delete(path="/artist/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Artist"},
     *   summary="Remove artist",
     *   description="",
     *   operationId="deleteArtist",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Artist id",
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
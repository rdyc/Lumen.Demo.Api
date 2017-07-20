<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentPatchRequest;
use App\Http\Requests\DocumentPostRequest;
use App\Repositories\Contracts\IDocumentRepository;
use App\Transformers\DocumentModelTransformer;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentController extends Controller
{

    /**
     * @var \App\Repositories\Contracts\IDocumentRepository
     */
    private $repo;

    public function __construct(IDocumentRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @SWG\Get(path="/document",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Get all documents",
     *   description="",
     *   operationId="getAllDocument",
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
     *     enum={}
     *   ),
     *   @SWG\Parameter(ref="#/parameters/Sorting"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/DocumentCollectionResponse")
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
                return $this->buildCollectionResponse($item, new DocumentModelTransformer);
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
     * @SWG\Get(path="/document/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Get single document",
     *   description="",
     *   operationId="getDocument",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Document ID",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/DocumentItemResponse")
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

            return $this->buildItemResponse($item, new DocumentModelTransformer);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Get(path="/document/{id}/file",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Get single document file",
     *   description="",
     *   operationId="getDocumentFile",
     *   produces={"application/*"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Document ID",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(type="file")
     *   ),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function getFileId($id)
    {
        try {
            $model = $this->repo->find($id);
            
            $transformer =  $this->buildItemResponse($model, new DocumentModelTransformer);

            $item = $transformer->getData()->data;

            $faker = Factory::create();

            $templateProcessor = new TemplateProcessor(app('path').'/../storage/template.docx');
            $docVars = $templateProcessor->getVariables();

            $items = [
                'Title' => $faker->company,
                'FullName' => $faker->name,
                'Address' => $faker->address,
                'JobTitle' => $faker->jobTitle,
                'Paragraph1st' => $faker->paragraph(10),
                'Paragraph2nd' => $faker->paragraph(6),
                'Paragraph3rd' => $faker->paragraph(),
                'CenterText' => $faker->sentence(),
                'RightText' => $faker->sentence()
            ];

            foreach ($items as $key => $value){
                $templateProcessor->setValue($key, $value);
            }

            $templateProcessor->setImg('Image', array('src' => app('path').'/../storage/_mars.jpg', 'size' => array(96, 77)));

            $templateProcessor->saveAs(app('path').'/../storage/tst.docx');

            /*return response()->make(utf8_decode($item->content), 200, [
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition' => 'attachment; filename="'. $item->name . '"',
                'Content-Type' => $item->mime. ';charset=utf-8',
                'Content-Length' => $item->size
            ]);*/

            return response($docVars);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Post(path="/document",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Creating document",
     *   description="",
     *   operationId="createDocument",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="document",
     *     type="file",
     *     description="Document file",
     *     required=true
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=201, ref="#/responses/Created"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function post()
    {
        try {
            $post = new DocumentPostRequest(Input::class);

            $model = $post->parse();

            $created = $this->repo->create($model);

            return response($created, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Patch(path="/document/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Updating document",
     *   description="",
     *   operationId="updateDocument",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Document ID",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="payload",
     *     description="Document data",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/DocumentPatchRequest")
     *   ),
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(response=202, ref="#/responses/Accepted"),
     *   @SWG\Response(response=400, ref="#/responses/BadRequest"),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=403, ref="#/responses/Forbidden"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function patch($id)
    {
        try {
            $patch = new DocumentPatchRequest(Input::all());

            $model = $patch->parse();

            $updated = $this->repo->update($id, $model);

            return response($updated, Response::HTTP_ACCEPTED);
        } catch (ValidationException $e) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $e->response);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (ModelNotFoundException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @SWG\Delete(path="/document/{id}",
     *   security={
     *     {"demo_auth": {}}
     *   },
     *   tags={"Document"},
     *   summary="Deleting document",
     *   description="",
     *   operationId="deleteDocument",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     description="Document ID",
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

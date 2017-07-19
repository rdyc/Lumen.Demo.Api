<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WhoamiController extends Controller
{
    protected $repo;

    /**
     * @SWG\Get(path="/whoami",
     *   security={
     *     {"demo_auth": {"profiles-read"}}
     *   },
     *   tags={"WhoAmI"},
     *   summary="Retrieve current user",
     *   description="",
     *   operationId="getMe",
     *   produces={"application/json"},
     *   @SWG\Parameter(ref="#/parameters/RequestedWith"),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *   ),
     *   @SWG\Response(response=401, ref="#/responses/Unauthorized"),
     *   @SWG\Response(response=500, ref="#/responses/GeneralError")
     * )
     **/
    public function get()
    {
        try {
            $user = Auth::user();

            return response($user);
        } catch (HttpException $e) {
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
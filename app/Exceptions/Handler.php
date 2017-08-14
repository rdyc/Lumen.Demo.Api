<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        // handle AJAX request
        if ($request->ajax()) {

            // predefined http error code
            $http_code = Response::HTTP_INTERNAL_SERVER_ERROR;

            if ($e instanceof ErrorException) {
                // nothing to change
            }

            if ($e instanceof HttpException) {
                // replace status code by given by http exception
                $http_code = (int) $e->getStatusCode();
            }

            // get status text by code
            $status_text = Response::$statusTexts[$http_code];

            // build error contents
            $error = [
                'http_code' => $http_code,
                'status_text' => $status_text,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ];

            // returned as json
            return response()->json($error, $http_code);
        }else{

            // this should be called from web browser
            return parent::render($request, $e);
        }
    }
}

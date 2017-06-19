<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends Controller
{
    public function get($version = 'V1')
    {
        try{
            $result = null;
            $http_code = Response::HTTP_OK;
            $app_path =app('path');

            $controller_path = $app_path . '/Http/Controllers/Api/' . strtoupper($version);
            $model_path = $app_path . '/Transformers';
            
            if(file_exists($controller_path))
            {
                $result = \Swagger\scan([$controller_path, $model_path ]);
            }else{
                $result = 'Api '. strtoupper($version) .' does not exist';
                $http_code = Response::HTTP_BAD_REQUEST;
            }
        }catch (\Exception $e){
            $result = $e->getMessage();
            $http_code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }finally{
            return response($result, $http_code);
        }
    }
}

<?php

namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        $this->app['auth']->viaRequest('api', function ($request) {
            $user = null;
             
            $authorization = $request->header('Authorization');

            if ($authorization) {
                $user = $this->getUser($authorization);
            }

            return (object) $user;
        });
    }

    /**
     * Retrieve user information from oauth server.
     *
     * @param $authorization
     * @return null|\App\Models\User
     */
    private function getUser($authorization)
    {
        try{
            $http = new Client([
                'base_uri' => config('oauth.baseUri'),
                'headers' => [
                    'Authorization' => $authorization,
                    'X-Requested-With' => 'XMLHttpRequest'
                ]
            ]);

            $response = $http->get(config('oauth.uriUser'));

            if ($response->getStatusCode() === 200)
                return json_decode((string)$response->getBody(), true);
            else
                return null;
        }catch(ClientException $e){
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody()->getContents());
            
            throw new HttpException($response->getStatusCode(), $responseBody->message);
        }
    }
}

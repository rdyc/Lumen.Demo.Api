<?php

namespace App\Providers;

use App\Models\OauthAccessToken;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\ServiceProvider;

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
            /*if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }*/

            $user = null;

            if ($request->header('Authorization')) {
                try {
                    $jwt = explode(' ', $request->header('Authorization')); // split -> Bearer <token>

                    if (!empty($jwt[1])) {
                        $decoded = JWT::decode($jwt[1], file_get_contents(storage_path() . '/oauth-public.key'), ['RS256']);

                        if ($decoded) {
                            $user = OauthAccessToken::find($decoded->jti)->user;
                        }
                    }
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
            }

            return $user;
        });
    }
}

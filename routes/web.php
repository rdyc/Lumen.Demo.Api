<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/docs[/{version}]', 'SwaggerController@get');

$app->group([
    'middleware' => 'auth',
    'prefix' => 'v1',
    'namespace' => 'V1'
], function () use ($app) {
    $app->group(['prefix' => 'whoami'], function () use ($app) {
        $app->get('/', 'WhoamiController@get');
    });

    $app->group(['prefix' => 'sync'], function () use ($app) {
        $app->get('/', 'SyncController@get');
        $app->post('/latest', 'SyncController@latest');
        $app->post('/pull', 'SyncController@pull');
        $app->patch('/push', 'SyncController@push');
        $app->post('/track', 'SyncController@track');
    });
});

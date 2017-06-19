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

$app->group(['middleware' => 'auth', 'prefix' => 'v1', 'namespace' => 'Api\V1'], function () use ($app) {
    $app->group(['prefix' => 'whoami'], function () use ($app) {
        $app->get('/', 'WhoamiController@get');
    });

    $app->group(['prefix' => 'artist'], function () use ($app) {
        $app->get('/', 'Master\ArtistController@get');
        $app->get('/{id}', 'Master\ArtistController@getId');
        $app->post('/', 'Master\ArtistController@post');
        $app->patch('/{id}', 'Master\ArtistController@patch');
        $app->delete('/{id}', 'Master\ArtistController@delete');
    });
});
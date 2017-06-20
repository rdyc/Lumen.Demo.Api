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
    'namespace' => 'Api\V1'
], function () use ($app) {
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

    $app->group(['prefix' => 'album'], function () use ($app) {
        $app->get('/', 'Master\AlbumController@get');
        $app->get('/{id}', 'Master\AlbumController@getId');
        $app->post('/', 'Master\AlbumController@post');
        $app->patch('/{id}', 'Master\AlbumController@patch');
        $app->delete('/{id}', 'Master\AlbumController@delete');
    });

    $app->group(['prefix' => 'track'], function () use ($app) {
        $app->get('/', 'Master\TrackController@get');
        $app->get('/{id}', 'Master\TrackController@getId');
        $app->post('/', 'Master\TrackController@post');
        $app->patch('/{id}', 'Master\TrackController@patch');
        $app->delete('/{id}', 'Master\TrackController@delete');
    });
});

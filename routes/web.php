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
    'middleware' => [
        'auth', 
        'cors'
    ],
    'prefix' => 'v1',
    'namespace' => 'V1'
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


    // TAP
    $app->group(['prefix' => 'general'], function () use ($app) {
        $app->get('/', 'Master\GeneralController@get');
        $app->get('/{id}', 'Master\GeneralController@getId');
        $app->post('/', 'Master\GeneralController@post');
        $app->patch('/{id}', 'Master\GeneralController@patch');
        $app->delete('/{id}', 'Master\GeneralController@delete');
    });

    $app->group(['prefix' => 'document'], function () use ($app) {
        $app->get('/', 'DocumentController@get');
        $app->get('/{id}', 'DocumentController@getId');
        $app->get('/{id}/file', 'DocumentController@getFileId');
        $app->post('/', 'DocumentController@post');
        $app->patch('/{id}', 'DocumentController@patch');
        $app->delete('/{id}', 'DocumentController@delete');
    });

});

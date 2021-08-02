<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function ($router) {
    $router->post('/games', [
        'as' => 'game.create',
        'uses'=> 'GameController@create',
    ]);

    $router->get('/games/{id}', [
        'as'   => 'game.get',
        'uses' => 'GameController@get',
    ]);


    $router->get('/games', [
        'as' => 'game.index',
        'uses' => 'GameController@index'
    ]);

    $router->put('/games/{id}', [
        'as' => 'game.update',
        'uses' => 'GameController@update'
    ]);

    $router->delete('/games/{id}', [
        'as' => 'game.delete',
        'uses' => 'GameController@delete'
    ]);
});

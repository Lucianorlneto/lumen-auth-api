<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use App\Http\Controllers\UserController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', [
            'uses' => 'UserController@index'
        ]);

        $router->get('/{userId}', [
            'uses' => 'UserController@show'
        ]);

        $router->post('/create', [
            'uses' => 'UserController@create'
        ]);

        $router->post('/update/{userId}', [
            'uses' => 'UserController@update'
        ]);

        $router->delete('/delete/{userId}', [
            'uses' => 'UserController@delete'
        ]);
    });
});



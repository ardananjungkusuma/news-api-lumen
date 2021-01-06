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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/news', 'NewsController@index');
$router->get('/news/detail/{slug}', 'NewsController@show');

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->group(['prefix' => 'news', 'middleware' => 'auth'], function () use ($router) {
    $router->post('/add', 'NewsController@add');
    $router->put('/edit/{slug}', 'NewsController@edit');
    $router->delete('/delete/{slug}', 'NewsController@delete');
});

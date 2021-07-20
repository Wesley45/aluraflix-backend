<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => '/api'], function () use ($router) {
    $router->get('videos', 'VideosController@index');
    $router->get('videos/{id}', 'VideosController@show');
    $router->post('videos', 'VideosController@store');
    $router->put('videos/{id}', 'VideosController@update');
    $router->delete('videos/{id}', 'VideosController@destroy');
});

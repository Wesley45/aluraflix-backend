<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => '/api'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'RegisterController@store');
    $router->get('profile', 'AuthController@me');
    $router->post('logout', 'AuthController@logout');
    $router->group(['prefix' => '/videos'], function () use ($router) {
        $router->get('/', 'VideosController@index');
        $router->get('/{id}', 'VideosController@show');
        $router->post('/', 'VideosController@store');
        $router->put('/{id}', 'VideosController@update');
        $router->delete('/{id}', 'VideosController@destroy');
    });
    $router->group(['prefix' => '/categories'], function () use ($router) {
        $router->get('/', 'CategoriesController@index');
        $router->post('/', 'CategoriesController@store');
        $router->get('/{id}', 'CategoriesController@show');
        $router->get('/{id}/videos', 'CategoriesController@getVideos');
        $router->put('/{id}', 'CategoriesController@update');
        $router->delete('/{id}', 'CategoriesController@destroy');
    });
});

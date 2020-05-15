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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['middleware' => 'auth','prefix'=>'api'], function () use ($router) {
    $router->get('user-preferences/user/{userid}', [
        'as' => 'user-preferences', 'uses' => 'UserpreferencesController@index'
    ]);
    $router->post('user-preferences/user/{userid}', [
        'as' => 'user-preferences', 'uses' => 'UserpreferencesController@store'
    ]);
    $router->patch('user-preferences/user/{userid}/id/{id}', [
        'as' => 'user-preferences', 'uses' => 'UserpreferencesController@update'
    ]);
    $router->delete('user-preferences/user/{userid}/id/{id}', [
        'as' => 'user-preferences', 'uses' => 'UserpreferencesController@destroy'
    ]);
});

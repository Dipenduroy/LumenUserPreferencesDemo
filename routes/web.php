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
    $router->get('userpreferences', [
        'as' => 'userpreferences', 'uses' => 'UserpreferencesController@index'
    ]);
    $router->post('userpreferences', [
        'as' => 'userpreferences', 'uses' => 'UserpreferencesController@store'
    ]);
    $router->delete('userpreferences', [
        'as' => 'userpreferences', 'uses' => 'UserpreferencesController@destroy'
    ]);
});

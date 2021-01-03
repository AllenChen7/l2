<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::namespace('Api')->name('api.')->group(function () {
//    // 短信验证码
//    Route::get('yy', 'TestController@yy')
//        ->name('yy');
//});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api'], function ($api) {
        // Endpoints registered here will have the "foo" middleware applied.
        $api->get('yy', 'TestController@yy');
        $api->post('auth/login', 'AuthController@login');
        $api->get('todo/list', 'ToDoController@index');
        $api->post('upload/image', 'UploadController@image');

        $api->get('wx/mini-login', 'WxController@wxMiniLogin');
    });

    $api->group([
        'namespace'  => 'App\Http\Controllers\Api',
        'middleware' => 'jwt.auth',
        'prefix'     => 'auth'
    ], function ($api) {
        $api->post('logout', 'AuthController@logout');
        $api->get('refresh', 'AuthController@refresh');
        $api->get('me', 'AuthController@me');
        $api->post('todo/add', 'ToDoController@add');
    });


    $api->group([
        'namespace'  => 'App\Http\Controllers\Api',
        'middleware' => 'jwt.auth',
    ], function ($api) {
        $api->post('todo/add', 'ToDoController@add');
        $api->get('todo/info', 'ToDoController@getInfo');
        $api->post('todo/done', 'ToDoController@done');
    });
});

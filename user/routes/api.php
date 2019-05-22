<?php

use Illuminate\Http\Request;

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

$_OPEN_API_DOMAIN = env('APP_OPEN_API_URL');
$_WHITE_LIST_DOMAIN = env('APP_WHITE_LIST_URL');

$_methodAll = ['options', 'get', 'post', 'put', 'delete'];
$_methodGet = ['options', 'get'];
$_methodPost = ['options', 'post'];
$_methodPut = ['options', 'put'];
$_methodDelete = ['options', 'delete'];

$_namespaceAPI = 'API';


$_API_VERSION = 'v1';
$_API_VERSION_PATH = 'api_'.$_API_VERSION;

/** Rou **/
Route::match($_methodAll, "{$_API_VERSION}/", "{$_namespaceAPI}\\RouterAPIController@index");


Route::group(/**
 *
 */
    [
        'namespace' => $_namespaceAPI,
//        'domain' => $_WHITE_LIST_DOMAIN,
//	'middleware' => []
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

    Route::match($_methodPost, 'test', 'UserAPIController@apiTest')->name('test');
    Route::match($_methodGet, 'service', 'UserAPIController@apiGetService')->name('user.read.service');
    Route::match($_methodGet, 'user', 'UserAPIController@apiGetUser')->name('user.read.user');
    Route::match($_methodGet, 'users', 'UserAPIController@apiGetUsers')->name('user.read.users');

    Route::match($_methodPost, 'callProduct', 'UserAPIController@apiCallProduct')->name('user.read.callProduct');
});



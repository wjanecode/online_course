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

//auth:api 即auth 带api参数
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//分类获取,先中间件验证api权限
Route::get('/cate','CategoryController@apiGet')->middleware('api');

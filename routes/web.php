<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info', function () {
    phpinfo();
});
Route::get('/user','ApiController@userApi');
Route::post('/userReg','ApiController@userReg');
Route::get('/test','ApiController@test');

//curl post发送数据
Route::get('/test/curlpost','ApiController@curlPost');  //form-data
Route::get('/test/curlpost2','ApiController@curlPost2');  //application/x-www-form-urlencoded
Route::get('/test/curlpost3','ApiController@curlPost3');  //raw

//中间件
Route::get('/test/mid','ApiController@testMid')->middleware('request10times');

//用户注册
Route::post('/test/user/reg','UserController@userReg');
//登录
Route::post('/test/user/login','UserController@userLogin');
//个人中心
Route::get('/test/user/my','UserController@userMy')->middleware(['CheckLogin','request10times']);


//资源路由
Route::resource('goods', GoodsController::class);









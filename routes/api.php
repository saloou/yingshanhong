<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*----------------------------------------------------------------------------------------*/


Route::get('/admin', function () {
    return view('layouts.admin');
});


Route::get('/getQrCode','GetQrCodeController@index')->middleware('auth:api');




Route::get('/products','ProductController@index');
Route::get('/products/{product}','ProductController@show');

Route::post('/products/create','ProductController@create');


Route::get('/sendSms','SendSmsController@test');

Route::post('/register','Auth\RegisterController@register');
Route::post('/login','Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::post('/token/refresh', 'Auth\LoginController@refresh');
Route::post('/user/profile/update', 'ProfileController@update')->middleware('auth:api');
Route::post('/user/password/update', 'PasswordController@update')->middleware('auth:api');



/*----------------------------------------------------------------------------------------*/
//微信 api 请求   token 认证服务器
Route::any('weixin/api', 'WeiXin\WeiXinController@api');

//微信 获取accessToken
Route::get('/getAccessToken', 'WeiXin\GetAccessTokenController@getAccessToken');

//微信 创建自定义菜单
Route::get('/createMenu', 'WeiXin\CreateMenuController@createMenu');



<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//var_dump(Auth::routes());exit();
#Auth::routes();
#Route::get('/home', 'HomeController@index');

# Роуты для входа/выхода
Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('logout', ['as' => 'auth.logout', 'uses' => 'Auth\LoginController@logout']);
#Роуты для регистрации
// По какой-то причине редиректит на /home зарегистрированных пользователей, надо делать свой контроллер
Route::group(['middleware' => 'auth'], function () {
	Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
	Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@register']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'Dashboard@index');
	Route::get('/server-list', 'Dashboard@server_list');
});

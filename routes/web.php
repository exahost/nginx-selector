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
///*Route::group(['middleware' => 'auth'], function () {
	Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
	Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@register']);
//});
//*/

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'Dashboard@index');
	Route::group(['prefix' => 'server_list'], function (){
		Route::get('add', 'Dashboard@ServerListAddView');
		Route::post('add', 'Dashboard@ServerListAdd');
		Route::get('edit/{id}', 'Dashboard@ServerListEditView')
			->where('id', '[0-9]+');
		Route::post('edit/{id}', 'Dashboard@ServerListEdit')
			->where('id', '[0-9]+');
		Route::get('enable/{id}', 'Dashboard@ServerListEnable')
			->where('id', '[0-9]+');
		Route::get('disable/{id}', 'Dashboard@ServerListDisable')
			->where('id', '[0-9]+');
		Route::get('remove/{id}', 'Dashboard@ServerListRemove')
			->where('id', '[0-9]+');
	});
	Route::group(['prefix' => 'upstream_list'], function (){
		Route::get('add', 'Dashboard@UpstreamListAddView');
		Route::post('add', 'Dashboard@UpstreamListAdd');
		Route::get('edit/{id}', 'Dashboard@UpstreamListEditView')
			->where('id', '[0-9]+');
		Route::post('edit/{id}', 'Dashboard@UpstreamListEdit')
			->where('id', '[0-9]+');
		Route::get('enable/{id}', 'Dashboard@UpstreamListEnable')
			->where('id', '[0-9]+');
		Route::get('disable/{id}', 'Dashboard@UpstreamListDisable')
			->where('id', '[0-9]+');
		Route::get('remove/{id}', 'Dashboard@UpstreamListRemove')
			->where('id', '[0-9]+');
	});
	Route::group(['prefix' => 'location_list'], function (){
		Route::get('add', 'Dashboard@LocationListAddView');
		Route::post('add', 'Dashboard@LocationListAdd');
		Route::get('edit/{id}', 'Dashboard@LocationListEditView')
			->where('id', '[0-9]+');
		Route::post('edit/{id}', 'Dashboard@LocationListEdit')
			->where('id', '[0-9]+');
		Route::get('enable/{id}', 'Dashboard@LocationListEnable')
			->where('id', '[0-9]+');
		Route::get('disable/{id}', 'Dashboard@LocationListDisable')
			->where('id', '[0-9]+');
		Route::get('remove/{id}', 'Dashboard@LocationListRemove')
			->where('id', '[0-9]+');
	});
	Route::get('generate', 'Dashboard@GenerateAndApply');
//	Route::get('/server-list', 'Dashboard@server_list');
});

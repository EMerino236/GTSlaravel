<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@home');
/* Login */
Route::post('/login', 'LoginController@login');
/* Dashboard */
Route::group(array('before'=>'auth'),function(){
	Route::get('/logout','LoginController@logout');
	Route::get('/dashboard','DashboardController@home');
});

/* Bienes */
Route::group(array('prefix'=>'bienes', 'before'=>'auth'),function(){
	Route::get('/','BienesController@home');
});

/* Users */
Route::group(array('prefix'=>'user', 'before'=>'auth'),function(){
	Route::get('/list_users','UserController@list_users');
	Route::get('/edit_user/{id}','UserController@render_edit_user');
	Route::post('/submit_edit_user','UserController@submit_edit_user');
	Route::get('/create_user','UserController@render_create_user');
	Route::post('/submit_create_user','UserController@submit_create_user');
	Route::post('/submit_disable_user','UserController@submit_disable_user');
	Route::post('/submit_enable_user','UserController@submit_enable_user');
	Route::get('/search_user','UserController@search_user');
});

/* Marcas */
Route::group(array('prefix'=>'marcas', 'before'=>'auth'),function(){
	Route::get('/list_marcas','MarcasController@list_marcas');
	Route::get('/search_marcas','MarcasController@search_marcas');
	Route::get('/create_marca','MarcasController@render_create_marca');
	Route::post('/submit_create_marca','MarcasController@submit_create_marca');
	Route::get('/edit_marca/{id}','MarcasController@render_edit_marca');
	Route::post('/submit_edit_marca','MarcasController@submit_edit_marca');
});

/* Familia de Activos */
Route::group(array('prefix'=>'familiaactivos', 'before'=>'auth'),function(){
	Route::get('/list_familiaactivos','FamiliaActivosController@list_familiaactivos');
	Route::get('/search_familiaactivos','FamiliaActivosController@search_familiaactivos');
	Route::get('/create_familiaactivo','FamiliaActivosController@render_create_familiaactivo');
	Route::post('/submit_create_familiaactivo','FamiliaActivosController@submit_create_familiaactivo');
	Route::get('/edit_familiaactivo/{id}','FamiliaActivosController@render_edit_familiaactivo');
	Route::post('/submit_edit_familiaactivo','FamiliaActivosController@submit_edit_familiaactivo');
});
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

/*Activos*/
Route::group(array('prefix'=>'equipos','before'=>'auth'),function(){
	Route::get('/','ActivosController@home');
	Route::get('/createEquipo','ActivosController@render_create_activo');
	Route::get('/submitEquipo','ActivosController@submit_create_activo');
	Route::get('/searchEquipo','ActivosController@home');
});

/*Configuraciones*/
Route::group(array('prefix'=>'configuraciones','before'=>'auth'),function(){
	Route::get('/','ConfiguracionesController@home');	
});

/*Areas*/
Route::group(array('prefix'=>'areas','before'=>'auth'),function(){
	Route::get('/list_areas','AreasController@list_areas');	
	Route::get('/create_area','AreasController@render_create_area');
	Route::post('/submit_area','AreasController@submit_create_area');
	Route::get('/edit_area/{id}','AreasController@render_edit_area');
	Route::get('/search_area','AreasController@search_area');
	Route::post('/submit_edit_area','AreasController@submit_edit_area');
	Route::post('/submit_disable_area','AreasController@submit_disable_area');
	Route::post('/submit_enable_area','AreasController@submit_enable_area');
});

/*Servicios*/
Route::group(array('prefix'=>'servicios','before'=>'auth'),function(){
	Route::post('/return_usuarios/{postData}','ServiciosController@return_usuarios');
	Route::get('/list_servicios','ServiciosController@list_servicios');	
	Route::get('/search_servicio','ServiciosController@search_servicio');
	Route::get('/edit_servicio/{id}','ServiciosController@render_edit_servicio');	
	Route::get('/create_servicio','ServiciosController@render_create_servicio');	
	Route::post('/submit_servicio','ServiciosController@submit_create_servicio');
	Route::post('/submit_edit_servicio','ServiciosController@submit_edit_servicio');
	Route::post('/submit_disable_servicio','ServiciosController@submit_disable_servicio');
	Route::post('/submit_enable_servicio','ServiciosController@submit_enable_servicio');
});

/*Grupos*/
Route::group(array('prefix'=>'grupos','before'=>'auth'),function(){
	Route::get('/list_grupos','GruposController@list_grupos');	
	Route::get('/search_grupo','GruposController@search_grupo');
	Route::get('/edit_grupo/{id}','GruposController@render_edit_grupo');	
	Route::get('/create_grupo','GruposController@render_create_grupo');	
	Route::post('/submit_grupo','GruposController@submit_create_grupo');
	Route::post('/submit_edit_grupo','GruposController@submit_edit_grupo');	
	Route::post('/submit_disable_grupo','GruposController@submit_disable_grupo');
	Route::post('/submit_enable_grupo','GruposController@submit_enable_grupo');
});

/*Reportes de Incumplimiento*/
Route::group(array('prefix'=>'reportes_incumplimiento','before'=>'auth'),function(){
	Route::post('/return_resp_servicio/{postData}','ReportesIncumplimientoController@return_responsable_servicio');
	Route::post('/return_contacto_proveedor/{postData}','ReportesIncumplimientoController@return_contacto_proveedor');
	Route::get('/list_reportes','ReportesIncumplimientoController@list_reportes_incumplimiento');	
	Route::get('/search_reporte','ReportesIncumplimientoController@search_reporte');
	Route::get('/create_reporte','ReportesIncumplimientoController@render_create_reporte');
});
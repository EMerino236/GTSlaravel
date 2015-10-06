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

/* Proveedores */
Route::group(array('prefix'=>'proveedores', 'before'=>'auth'),function(){
	Route::get('/list_proveedores','ProveedorController@list_proveedores');
	Route::get('/edit_proveedor/{id}','ProveedorController@render_edit_proveedor');
	Route::post('/submit_edit_proveedor','ProveedorController@submit_edit_proveedor');
	Route::get('/create_proveedor','ProveedorController@render_create_proveedor');
	Route::post('/submit_create_proveedor','ProveedorController@submit_create_proveedor');
	Route::post('/submit_disable_proveedor','ProveedorController@submit_disable_proveedor');
	Route::post('/submit_enable_proveedor','ProveedorController@submit_enable_proveedor');
	Route::get('/search_proveedor','ProveedorController@search_proveedor');
});

/* SOT */
Route::group(array('prefix'=>'sot', 'before'=>'auth'),function(){
	Route::get('/list_sots','SotController@list_sots');
	Route::get('/edit_sot/{id}','SotController@render_edit_sot');
	Route::post('/submit_edit_sot','SotController@submit_edit_sot');
	Route::get('/create_sot','SotController@render_create_sot');
	Route::post('/submit_create_sot','SotController@submit_create_sot');
	Route::post('/submit_disable_sot','SotController@submit_disable_sot');
	Route::get('/search_sot','SotController@search_sot');
	Route::post('/submit_program_ot','SotController@submit_program_ot');
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
Route::group(array('prefix'=>'familia_activos', 'before'=>'auth'),function(){
	Route::get('/list_familia_activos','FamiliaActivosController@list_familia_activos');
	Route::get('/search_familia_activos','FamiliaActivosController@search_familia_activos');
	Route::get('/create_familia_activo','FamiliaActivosController@render_create_familia_activo');
	Route::post('/submit_create_familia_activo','FamiliaActivosController@submit_create_familia_activo');
	Route::get('/edit_familia_activo/{id}','FamiliaActivosController@render_edit_familia_activo');
	Route::post('/submit_edit_familia_activo','FamiliaActivosController@submit_edit_familia_activo');
});

/*Activos*/
Route::group(array('prefix'=>'equipos','before'=>'auth'),function(){
	Route::get('/','ActivosController@home');
	Route::get('/list_equipos','ActivosController@list_activos');
	Route::get('/search_equipos','ActivosController@search_activos');
	Route::get('/create_equipo','ActivosController@render_create_activo');
	Route::get('/submit_equipo','ActivosController@submit_create_activo');
	Route::post('/search_ubicacion_ajax','ActivosController@search_ubicacion_ajax');
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
	Route::post('/return_name_responsable/{postData}','ReportesIncumplimientoController@return_name_responsable');
	Route::post('/return_name_contrato/{postData}','ReportesIncumplimientoController@return_name_contrato');
	Route::post('/download_contract/{postData}','ReportesIncumplimientoController@get_codigoArchivamento');
	Route::post('/download_contrato','ReportesIncumplimientoController@download_contrato');
	Route::get('/list_reportes','ReportesIncumplimientoController@list_reportes_incumplimiento');	
	Route::get('/search_reporte','ReportesIncumplimientoController@search_reporte');
	Route::get('/edit_reporte/{id}','ReportesIncumplimientoController@render_edit_reporte');
	Route::get('/create_reporte','ReportesIncumplimientoController@render_create_reporte');
	Route::post('/return_contacto_proveedor/{postData}','ReportesIncumplimientoController@return_contacto_proveedor');
	Route::get('/list_reportes','ReportesIncumplimientoController@list_reportes_incumplimiento');	
	Route::get('/create_reporte','ReportesIncumplimientoController@render_create_reporte');
	Route::post('/submit_reporte','ReportesIncumplimientoController@submit_create_reporte');
	Route::post('/submit_edit_reporte','ReportesIncumplimientoController@submit_edit_reporte');	
	Route::post('/submit_disable_reporte','ReportesIncumplimientoController@submit_disable_reporte');
	Route::post('/submit_enable_reporte','ReportesIncumplimientoController@submit_enable_reporte');

});
/* Mantenimiento Correctivo */
Route::group(array('prefix'=>'mant_correctivo','before'=>'auth'),function(){
	Route::get('/programacion/{id}','OtController@render_program_ot_mant_correctivo');
	Route::post('/submit_programacion','OtController@submit_program_ot_mant_correctivo');
	Route::post('/calendario_ot_mant_correctivo','OtController@calendario_ot_mant_correctivo_ajax');
	Route::get('/list_mant_correctivo','OtController@list_mant_correctivo');
	Route::get('/search_ot_mant_correctivo','OtController@search_ot_mant_correctivo');
	Route::get('/create_ot/{id}','OtController@render_create_ot');
	Route::post('/submit_create_ot','OtController@submit_create_ot');

});
/* Tipo de Tareas */
Route::group(array('prefix'=>'tipoTarea', 'before'=>'auth'),function(){
	Route::get('/list_tipoTareas','TipoTareaController@list_tipoTareas');
	Route::get('/edit_tipoTarea/{id}','TipoTareaController@render_edit_tipoTarea');
	Route::post('/submit_edit_tipoTarea','TipoTareaController@submit_edit_tipoTarea');
	Route::get('/create_tipoTarea','TipoTareaController@render_create_tipoTarea');
	Route::post('/submit_create_tipoTarea','TipoTareaController@submit_create_tipoTarea');
	Route::get('/search_tipoTarea','TipoTareaController@search_tipoTarea');
	Route::post('/submit_disable_tipoTarea','TipoTareaController@submit_disable_tipoTarea');
	Route::post('/submit_enable_tipoTarea','TipoTareaController@submit_enable_tipoTarea');	
});

/* Documentos */
Route::group(array('prefix'=>'documento', 'before'=>'auth'),function(){
	Route::get('/list_documentos','DocumentoController@list_documentos');
	Route::get('/edit_documento/{id}','DocumentoController@render_edit_documento');
	Route::post('/submit_edit_documento','DocumentoController@submit_edit_documento');
	Route::get('/create_documento','DocumentoController@render_create_documento');
	Route::post('/submit_create_documento','DocumentoController@submit_create_documento');
	Route::get('/search_documento','DocumentoController@search_documento');
	Route::post('/download_documento','DocumentoController@download_documento');
});

/* Solicitudes Compra */
Route::group(array('prefix'=>'solicitudes_compra', 'before'=>'auth'),function(){
	Route::get('/list_solicitudes','SolicitudesController@list_solicitudes');
	Route::get('/search_solicitud','SolicitudesController@search_solicitud');
	Route::post('/return_servicios/{postData}','SolicitudesController@return_servicio');
});
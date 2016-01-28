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
Route::get('/login', 'LoginController@login_expires');
Route::post('/login', 'LoginController@login');
/* Dashboard */
Route::group(array('before'=>'auth'),function(){
	Route::get('/logout','LoginController@logout');
	Route::get('/dashboard','DashboardController@home');
	Route::get('/mision_vision','DashboardController@mision_vision');
	Route::get('/acerca_desarrollo','DashboardController@acerca_desarrollo');
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
	Route::get('/view_user/{id}','UserController@render_view_user');
	
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
	Route::get('/view_proveedor/{id}','ProveedorController@render_view_proveedor');
	Route::get('/create_soporte_tecnico_proveedor/{id}','ProveedorController@render_create_soporte_tecnico_proveedor');
	Route::post('/submit_create_soporte_tecnico_proveedor','ProveedorController@submit_create_soporte_tecnico_proveedor');
	Route::get('/edit_soporte_tecnico_proveedor/{id}','ProveedorController@render_edit_soporte_tecnico_proveedor');
	Route::post('/submit_edit_soporte_tecnico_proveedor','ProveedorController@submit_edit_soporte_tecnico_proveedor');
	Route::get('/view_soporte_tecnico_proveedor/{id}','ProveedorController@render_view_soporte_tecnico_proveedor');
	Route::post('submit_delete_soporte_tecnico_proveedor_ajax','ProveedorController@submit_delete_soporte_tecnico_proveedor_ajax');
});

/* SOT */
Route::group(array('prefix'=>'sot', 'before'=>'auth'),function(){
	Route::get('/list_sots','SotController@list_sots');
	Route::get('/edit_sot/{id}','SotController@render_edit_sot');
	//Route::post('/submit_edit_sot','SotController@submit_edit_sot');
	Route::get('/create_sot','SotController@render_create_sot');
	Route::post('/submit_create_sot','SotController@submit_create_sot');
	Route::post('/submit_disable_sot','SotController@submit_disable_sot');
	Route::get('/search_sot','SotController@search_sot');
	Route::post('/submit_program_ot','SotController@submit_program_ot');
	Route::post('/search_equipo_ajax','SotController@search_equipo_ajax');
	Route::post('/submit_disable_sot_false_alarm','SotController@submit_disable_sot_false_alarm');
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
	Route::get('/view_familia_activo/{id}','FamiliaActivosController@render_view_familia_activo');

	Route::get('/create_modelo_familia_activo/{id}','ModeloActivosController@render_create_modelo_familia_activo');
	Route::post('/submit_create_modelo_familia_activo','ModeloActivosController@submit_create_modelo_familia_activo');
	Route::post('/submit_delete_accesorio_ajax/','AccesoriosController@submit_delete_accesorio_ajax');
	Route::post('/submit_delete_componente_ajax/','ComponenteController@submit_delete_componente_ajax');
	Route::post('/submit_delete_consumible_ajax/','ConsumibleController@submit_delete_consumible_ajax');
	Route::get('/edit_modelo_familia_activo/{id}','ModeloActivosController@render_edit_modelo_familia_activo');
	Route::post('/submit_edit_modelo_familia_activo','ModeloActivosController@submit_edit_modelo_familia_activo');
	Route::get('/create_accesorio_modelo_familia_activo/{id}','ModeloActivosController@render_create_accesorio_modelo_familia_activo');
	Route::post('/submit_create_accesorio_modelo_familia_activo','ModeloActivosController@submit_create_accesorio_modelo_familia_activo');
	Route::get('/create_componente_modelo_familia_activo/{id}','ModeloActivosController@render_create_componente_modelo_familia_activo');
	Route::post('/submit_create_componente_modelo_familia_activo','ModeloActivosController@submit_create_componente_modelo_familia_activo');
	Route::get('/create_consumible_modelo_familia_activo/{id}','ModeloActivosController@render_create_consumible_modelo_familia_activo');
	Route::post('/submit_create_consumible_modelo_familia_activo','ModeloActivosController@submit_create_consumible_modelo_familia_activo');
	Route::get('/view_modelo_familia_activo/{id}','ModeloActivosController@render_view_modelo_familia_activo');
	Route::post('/submit_delete_modelo_familia_activo/','ModeloActivosController@submit_delete_modelo_familia_activo');
	
});

/*Activos*/
Route::group(array('prefix'=>'equipos','before'=>'auth'),function(){
	Route::get('/','ActivosController@home');
	Route::get('/list_equipos','ActivosController@list_activos');
	Route::get('/search_equipos','ActivosController@search_activos');
	Route::get('/create_equipo','ActivosController@render_create_activo');
	Route::post('/submit_create_equipo','ActivosController@submit_create_activo');
	Route::get('/edit_equipo/{id}','ActivosController@render_edit_activo');
	Route::post('/submit_edit_equipo','ActivosController@submit_edit_activo');
	Route::get('/view_equipo/{id}','ActivosController@render_view_activo');

	Route::get('/list_inventario','ActivosController@list_inventario');
	Route::get('/search_inventario','ActivosController@search_inventario');
	Route::get('/view_inventario/{id}','ActivosController@render_view_activo_inventario');

	Route::get('/create_soporte_tecnico_equipo/{id}','ActivosController@render_create_soporte_tecnico_equipo');
	Route::post('/submit_create_soporte_tecnico_equipo','ActivosController@submit_create_soporte_tecnico_equipo');
	Route::post('/submit_delete_soporte_tecnico_equipo_ajax','ActivosController@submit_delete_soporte_tecnico_equipo_ajax');

	Route::post('/search_nombre_equipo_ajax','ActivosController@search_nombre_equipo_ajax');
	Route::post('/search_modelo_equipo_ajax','ActivosController@search_modelo_equipo_ajax');
	Route::post('/validate_numero_reporte_ajax','ActivosController@validate_numero_reporte_ajax');
	Route::post('/search_soporte_tecnico_ajax','ActivosController@render_view_soporte_tecnico');
});

/*Soporte Técnico*/
Route::group(array('prefix'=>'soportes_tecnico','before'=>'auth'),function(){
	Route::get('/list_soporte_tecnico','SoportesTecnicoController@list_soporte_tecnico');
	Route::get('/search_soporte_tecnico','SoportesTecnicoController@search_soporte_tecnico');
	Route::get('/view_soporte_tecnico/{id}','SoportesTecnicoController@render_view_soporte_tecnico');

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
	Route::get('/view_area/{id}','AreasController@render_view_area');
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
	Route::get('/view_grupo/{id}','GruposController@render_view_grupo');
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
	Route::post('/validate_ot','ReportesIncumplimientoController@validate_ot');
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
	Route::get('/view_reporte/{id}','ReportesIncumplimientoController@render_view_reporte');
});
/* Mantenimiento Correctivo */
Route::group(array('prefix'=>'mant_correctivo','before'=>'auth'),function(){
	Route::get('/programacion/{id}','OtController@render_program_ot_mant_correctivo');
	Route::post('/submit_programacion','OtController@submit_program_ot_mant_correctivo');
	Route::get('/list_mant_correctivo','OtController@list_mant_correctivo');
	Route::get('/search_ot_mant_correctivo','OtController@search_ot_mant_correctivo');
	Route::get('/create_ot/{id}','OtController@render_create_ot');
	Route::post('/submit_create_ot','OtController@submit_create_ot');
	Route::post('/submit_create_tarea_ajax','OtController@submit_create_tarea_ajax');
	Route::post('/submit_delete_tarea_ajax','OtController@submit_delete_tarea_ajax');
	Route::post('/submit_create_repuesto_ajax','OtController@submit_create_repuesto_ajax');
	Route::post('/submit_delete_repuesto_ajax','OtController@submit_delete_repuesto_ajax');
	Route::post('/submit_create_personal_ajax','OtController@submit_create_personal_ajax');
	Route::post('/submit_delete_personal_ajax','OtController@submit_delete_personal_ajax');
	Route::post('/ver_programaciones','OtController@search_programaciones');
	Route::post('/export_pdf','OtController@export_pdf');
	Route::get('/view_ot/{id}','OtController@render_view_ot');	
});
/* Retiro Servicio */
Route::group(array('prefix'=>'retiro_servicio','before'=>'auth'),function(){
	/* Reporte de retiro de servicio */
	Route::get('/create_reporte_retiro_servicio','RetiroServicioController@render_create_reporte_retiro_servicio');
	Route::post('/submit_create_reporte_retiro_servicio','RetiroServicioController@submit_create_reporte_retiro_servicio');
	Route::get('/list_reporte_retiro_servicio','RetiroServicioController@list_reporte_retiro_servicio');
	Route::get('/search_reporte_retiro_servicio','RetiroServicioController@search_reporte_retiro_servicio');
	Route::get('/edit_reporte_retiro_servicio/{id}','RetiroServicioController@render_edit_reporte_retiro_servicio');
	Route::get('/view_reporte_retiro_servicio/{id}','RetiroServicioController@render_view_reporte_retiro_servicio');
	Route::post('/submit_disable_reporte_retiro_servicio','RetiroServicioController@submit_disable_reporte_retiro_servicio');
	Route::post('/search_equipo_ajax','RetiroServicioController@search_equipo_ajax');
	/*
	Route::get('/programacion','RetiroServicioController@render_program_ot_retiro_servicio');
	Route::post('/submit_programacion','RetiroServicioController@submit_program_ot_mant_correctivo');
	Route::post('/calendario_ot_mant_correctivo','RetiroServicioController@calendario_ot_mant_correctivo_ajax');
	*/
	Route::post('/ver_programaciones','RetiroServicioController@search_programaciones');
	Route::get('/list_retiro_servicio','RetiroServicioController@list_retiro_servicio');
	Route::get('/search_ot_retiro_servicio','RetiroServicioController@search_ot_retiro_servicio');
	Route::get('/programacion/{id}','RetiroServicioController@render_program_ot_retiro_servicio');
	Route::post('/submit_programacion','RetiroServicioController@submit_program_ot_retiro_servicio');
	Route::get('/search_ot_retiro_servicio','RetiroServicioController@search_ot_retiro_servicio');
	Route::get('/create_ot/{id}','RetiroServicioController@render_create_ot');
	Route::post('/submit_create_ot','RetiroServicioController@submit_create_ot');
	Route::post('/submit_create_tarea_ajax','RetiroServicioController@submit_create_tarea_ajax');
	Route::post('/submit_delete_tarea_ajax','RetiroServicioController@submit_delete_tarea_ajax');
	Route::post('/submit_create_personal_ajax','RetiroServicioController@submit_create_personal_ajax');
	Route::post('/submit_delete_personal_ajax','RetiroServicioController@submit_delete_personal_ajax');
	Route::post('/export_pdf','RetiroServicioController@export_pdf');
	Route::get('/view_ot/{id}','RetiroServicioController@render_view_ot');
});

/* Marcar Tareas */
/*
Route::group(array('prefix'=>'marcar_tarea','before'=>'auth'),function(){
	Route::post('/submit_marcar_tarea_ajax','OtController@submit_marcar_tarea_ajax');
});
*/
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
	Route::post('/submit_disable_documento','DocumentoController@submit_disable_documento');
	Route::post('/submit_enable_documento','DocumentoController@submit_enable_documento');
	Route::get('/view_documento/{id}','DocumentoController@render_view_documento');	
});

/* Solicitudes Compra */
Route::group(array('prefix'=>'solicitudes_compra', 'before'=>'auth'),function(){
	Route::get('/list_solicitudes','SolicitudesController@list_solicitudes');
	Route::get('/search_solicitudes','SolicitudesController@search_solicitud');	
	Route::get('/create_solicitud','SolicitudesController@render_create_solicitud');
	Route::post('/submit_create_solicitud_compra','SolicitudesController@submit_create_solicitud');
	Route::post('/return_equipos','SolicitudesController@search_equipos_ajax');
	Route::post('/return_activos','SolicitudesController@search_activos_ajax');
	Route::post('/download_reporte','SolicitudesController@download_reporte');
	Route::post('/validate_ot','SolicitudesController@validate_ot');
	Route::post('/return_tiempo_maximo','SolicitudesController@get_tiempo_maximo');
	Route::post('/return_name_reporte','SolicitudesController@return_name_reporte');
	Route::get('/edit_solicitud_compra/{id}','SolicitudesController@render_edit_solicitud');
	Route::post('/submit_edit_solicitud_compra','SolicitudesController@submit_edit_solicitud');		
	Route::post('/submit_disable_solicitud','SolicitudesController@submit_disable_solicitud');
	Route::post('/submit_enable_solicitud','SolicitudesController@submit_enable_solicitud');	
	Route::post('/export_pdf','SolicitudesController@export_pdf');
	Route::get('/view_solicitud_compra/{id}','SolicitudesController@render_view_solicitud');
	
});


/* Reporte de Instalación */
Route::group(array('prefix'=>'rep_instalacion','before'=>'auth'),function(){
	Route::get('/list_rep_instalacion','ReportesInstalacionController@list_rep_instalacion');
	Route::get('/edit_rep_instalacion/{id}','ReportesInstalacionController@render_edit_rep_instalacion');
	Route::post('/submit_edit_rep_instalacion','ReportesInstalacionController@submit_edit_rep_instalacion');
	Route::get('/create_rep_instalacion/{id?}','ReportesInstalacionController@render_create_rep_instalacion');
	Route::post('/submit_create_rep_instalacion','ReportesInstalacionController@submit_create_rep_instalacion');
	Route::get('/search_rep_instalacion','ReportesInstalacionController@search_rep_instalacion');
	Route::post('/return_name_responsable/{postData}','ReportesInstalacionController@return_name_responsable');
	Route::post('/return_name_doc_relacionado/{postData}','ReportesInstalacionController@return_name_doc_relacionado');
	Route::post('/return_num_rep_entorno_concluido/{postData}','ReportesInstalacionController@return_num_rep_entorno_concluido');	
	Route::get('/download_documento/{id?}','ReportesInstalacionController@download_documento');
	Route::get('/view_rep_instalacion/{id}','ReportesInstalacionController@render_view_rep_instalacion');
});

/*Acta de Conformidad*/
Route::group(array('prefix'=>'actas_conformidad','before'=>'auth'),function(){
	Route::get('/list_actas','ActasConformidadController@list_actas');	
	Route::get('/create_acta','ActasConformidadController@render_create_acta');
	Route::post('/submit_create_acta','ActasConformidadController@submit_create_acta');
	Route::get('/edit_acta/{id}','ActasConformidadController@render_edit_acta');
	Route::get('/search_acta','ActasConformidadController@search_acta');
	Route::post('/submit_edit_acta','ActasConformidadController@submit_edit_acta');
	Route::post('/submit_disable_acta','ActasConformidadController@submit_disable_acta');
	Route::post('/submit_enable_acta','ActasConformidadController@submit_enable_acta');
	Route::post('/return_name_acta','ActasConformidadController@return_name_acta');
	Route::post('/download_acta','ActasConformidadController@download_acta');
	Route::get('/view_acta/{id}','ActasConformidadController@render_view_acta');
});

/* Mantenimiento Preventivo */
Route::group(array('prefix'=>'mant_preventivo','before'=>'auth'),function(){
	Route::get('/programacion','OtPreventivoController@render_program_ot_mant_preventivo');
	Route::post('/submit_programacion','OtPreventivoController@submit_program_ot_mant_preventivo');
	Route::get('/list_mant_preventivo','OtPreventivoController@list_mant_preventivo');
	Route::post('/search_equipo_ajax','OtPreventivoController@search_equipo_ajax');
	Route::post('/ver_programaciones','OtPreventivoController@search_programaciones');
	Route::get('/search_ot_mant_preventivo','OtPreventivoController@search_ot_mant_preventivo');
	Route::get('/create_ot_preventivo/{id}','OtPreventivoController@render_create_ot');
	Route::post('/submit_create_ot','OtPreventivoController@submit_create_ot');	
	Route::post('/submit_create_tarea_ajax','OtPreventivoController@submit_create_tarea_ajax');
	Route::post('/submit_marcar_tarea_ajax','OtPreventivoController@submit_marcar_tarea_ajax');
	Route::post('/submit_delete_tarea_ajax','OtPreventivoController@submit_delete_tarea_ajax');
	Route::post('/submit_create_repuesto_ajax','OtPreventivoController@submit_create_repuesto_ajax');
	Route::post('/submit_delete_repuesto_ajax','OtPreventivoController@submit_delete_repuesto_ajax');
	Route::post('/submit_create_personal_ajax','OtPreventivoController@submit_create_personal_ajax');
	Route::post('/submit_delete_personal_ajax','OtPreventivoController@submit_delete_personal_ajax');	
	Route::post('/submit_disable_preventivo','OtPreventivoController@submit_disable_preventivo');
	Route::post('/export_pdf','OtPreventivoController@export_pdf');
	Route::get('/view_ot_preventivo/{id}','OtPreventivoController@render_view_ot');
});

/* Verificación Metrológica */
Route::group(array('prefix'=>'verif_metrologica','before'=>'auth'),function(){
	Route::get('/programacion','OtVerificacionMetrologicaController@render_program_ot_verif_metrologica');
	Route::post('/submit_programacion','OtVerificacionMetrologicaController@submit_program_ot_verif_metrologica');
	Route::post('/calendario_ot_mant_correctivo','OtVerificacionMetrologicaController@calendario_ot_verif_metrologica_ajax');
	Route::get('/list_verif_metrologica','OtVerificacionMetrologicaController@list_verif_metrologica');
	Route::post('/search_equipo_ajax','OtVerificacionMetrologicaController@search_equipo_ajax');
	Route::post('/ver_programaciones','OtVerificacionMetrologicaController@search_programaciones');
	Route::get('/search_ot_verif_metrologica','OtVerificacionMetrologicaController@search_ot_verif_metrologica');
	Route::get('/create_ot_verif_metrologica/{id}','OtVerificacionMetrologicaController@render_create_ot_verif_metrologica');
	Route::post('/submit_create_ot','OtVerificacionMetrologicaController@submit_create_ot');
	Route::post('/submit_create_personal_ajax','OtVerificacionMetrologicaController@submit_create_personal_ajax');
	Route::post('/submit_delete_personal_ajax','OtVerificacionMetrologicaController@submit_delete_personal_ajax');
	Route::post('/return_name_doc_relacionado/{postData}','OtVerificacionMetrologicaController@return_name_doc_relacionado');
	Route::get('/download_documento/{id?}','OtVerificacionMetrologicaController@download_documento');
	Route::post('/export_pdf','OtVerificacionMetrologicaController@export_pdf');
	Route::post('/submit_disable_verif_metrologica','OtVerificacionMetrologicaController@submit_disable_verif_metrologica');
	Route::get('/view_ot_verif_metrologica/{id}','OtVerificacionMetrologicaController@render_view_ot_verif_metrologica');
});

/* Inspeccion de Equipos */
Route::group(array('prefix'=>'inspec_equipos','before'=>'auth'),function(){
	Route::get('/programacion','OtInspeccionEquiposController@render_program_ot_inspeccion_equipo');
	Route::post('/submit_programacion','OtInspeccionEquiposController@submit_program_ot_inspec_equipos');
	Route::get('/list_inspec_equipos','OtInspeccionEquiposController@list_inspec_equipos');
	Route::post('/ver_programaciones','OtInspeccionEquiposController@search_programaciones');
	Route::get('/search_ot_inspec_equipos','OtInspeccionEquiposController@search_ot_inspeccion_equipos');
	Route::post('/search_servicio_ajax','OtInspeccionEquiposController@search_servicio_ajax');
	Route::get('/create_ot_inspeccion_equipos/{id}','OtInspeccionEquiposController@render_create_ot');
	//Route::post('/submit_create_ot','OtInspecEquiposController@submit_create_ot');
	Route::post('/submit_marcar_tarea_ajax','OtInspeccionEquiposController@submit_marcar_tarea_ajax');
	Route::post('/validate_servicio','OtInspeccionEquiposController@validate_servicio');
	Route::post('/submit_disable_inspeccion','OtInspeccionEquiposController@submit_disable_inspeccion');
	Route::post('/submit_create_ot','OtInspeccionEquiposController@submit_create_ot');
	Route::post('/export_pdf','OtInspeccionEquiposController@export_pdf');
	Route::get('/view_ot_inspeccion_equipos/{id}','OtInspeccionEquiposController@render_view_ot');
	
});

/* Planificacion */
Route::group(array('prefix'=>'planeamiento', 'before'=>'auth'),function(){
	Route::get('/','PlaneamientoController@home');
});

/* Reporte CN */
Route::group(array('prefix'=>'reporte_cn','before'=>'auth'),function(){
	Route::get('/list_reporte_cn','ReporteCNController@list_reporte_cn');
	Route::get('/edit_reporte_cn/{id}','ReporteCNController@render_edit_reporte_cn');
	Route::get('/view_reporte_cn/{id}','ReporteCNController@render_view_reporte_cn');
	Route::post('/submit_edit_reporte_cn','ReporteCNController@submit_edit_reporte_cn');
	Route::get('/create_reporte_cn/{id?}','ReporteCNController@render_create_reporte_cn');
	Route::post('/submit_create_reporte_cn','ReporteCNController@submit_create_reporte_cn');
	Route::get('/search_reporte_cn','ReporteCNController@search_reporte_cn');
	Route::post('/return_num_ot_retiro/{postData}','ReporteCNController@return_num_ot_retiro');
	Route::post('/return_num_doc_responsable_cn/{postData}','ReporteCNController@return_num_doc_responsable_cn');
	Route::post('/return_area/{postData}','ReporteCNController@return_area');
	Route::get('/download_documento/{id}','ReporteCNController@download_documento');
	Route::post('/submit_disable_reporte_cn','ReporteCNController@submit_disable_reporte_cn');
	Route::post('/submit_enable_reporte_cn','ReporteCNController@submit_enable_reporte_cn');
});

/* Reporte ETES */
Route::group(array('prefix'=>'reporte_etes','before'=>'auth'),function(){
	Route::get('/list_reporte_etes','ReporteETESController@list_reporte_etes');
	Route::get('/edit_reporte_etes/{id}','ReporteETESController@render_edit_reporte_etes');
	Route::post('/submit_edit_reporte_etes','ReporteETESController@submit_edit_reporte_etes');
	Route::get('/create_reporte_etes/{id?}','ReporteETESController@render_create_reporte_etes');
	Route::post('/submit_create_reporte_etes','ReporteETESController@submit_create_reporte_etes');
	Route::get('/search_reporte_etes','ReporteETESController@search_reporte_etes');
	Route::get('/download_documento/{id}','ReporteETESController@download_documento');
	Route::post('/submit_disable_reporte_etes','ReporteETESController@submit_disable_reporte_etes');
	Route::post('/submit_enable_reporte_etes','ReporteETESController@submit_enable_reporte_etes');
});

/* Reporte PAAC */
Route::group(array('prefix'=>'reporte_paac','before'=>'auth'),function(){
	Route::get('/list_reporte_paac','ReportePAACController@list_reporte_paac');
	Route::get('/edit_reporte_paac/{id}','ReportePAACController@render_edit_reporte_paac');
	Route::get('/view_reporte_paac/{id}','ReportePAACController@render_view_reporte_paac');
	Route::post('/submit_edit_reporte_paac','ReportePAACController@submit_edit_reporte_paac');
	Route::get('/create_reporte_paac/{id?}','ReportePAACController@render_create_reporte_paac');
	Route::post('/submit_create_reporte_paac','ReportePAACController@submit_create_reporte_paac');
	Route::get('/search_reporte_paac','ReportePAACController@search_reporte_paac');
	Route::get('/download_documento/{id}','ReportePAACController@download_documento');
	Route::post('/submit_disable_reporte_paac','ReportePAACController@submit_disable_reporte_paac');
	Route::post('/submit_enable_reporte_paac','ReportePAACController@submit_enable_reporte_paac');
	Route::post('/return_num_doc_responsable_paac/{postData}','ReportePAACController@return_num_doc_responsable_paac');
});

/* Cotizaciones */
Route::group(array('prefix'=>'cotizaciones','before'=>'auth'),function(){
	Route::get('/list_cotizacion','CotizacionController@list_cotizacion');
	Route::get('/view_cotizacion/{id}','CotizacionController@render_view_cotizacion');
	Route::post('/submit_edit_cotizacion','CotizacionController@submit_edit_cotizacion');
	Route::get('/create_cotizacion','CotizacionController@render_create_cotizacion');
	Route::post('/submit_create_cotizacion','CotizacionController@submit_create_cotizacion');
	Route::get('/search_cotizacion','CotizacionController@search_cotizacion');
	Route::get('/download_documento/{id}','CotizacionController@download_documento');
	Route::post('/export_pdf','CotizacionController@export_pdf');
});

/* Documentos PAAC */
Route::group(array('prefix'=>'documentos_PAAC','before'=>'auth'),function(){
	Route::get('/list_documento_paac','DocumentoPAACController@list_documento_paac');
	Route::get('/edit_documento_paac/{id}','DocumentoPAACController@render_edit_documento_paac');
	Route::get('/view_documento_paac/{id}','DocumentoPAACController@render_view_documento_paac');
	Route::post('/submit_edit_documento_paac','DocumentoPAACController@submit_edit_documento_paac');
	Route::get('/create_documento_paac','DocumentoPAACController@render_create_documento_paac');
	Route::post('/submit_create_documento_paac','DocumentoPAACController@submit_create_documento_paac');
	Route::get('/search_documento_paac','DocumentoPAACController@search_documento_paac');
	Route::get('/download_documento/{id}','DocumentoPAACController@download_documento');
	Route::post('/submit_disable_documento_paac','DocumentoPAACController@submit_disable_documento_paac');
	Route::post('/submit_enable_documento_paac','DocumentoPAACController@submit_enable_documento_paac');
});

/* Plan Director */
Route::group(array('prefix'=>'plan_director','before'=>'auth'),function(){
	Route::get('/list_documento_plan_director','DocumentoPlanDirectorController@list_documento_plan_director');
	Route::get('/edit_documento_plan_director/{id}','DocumentoPlanDirectorController@render_edit_documento_plan_director');
	Route::get('/view_documento_plan_director/{id}','DocumentoPlanDirectorController@render_view_documento_plan_director');
	Route::post('/submit_edit_documento_plan_director','DocumentoPlanDirectorController@submit_edit_documento_plan_director');
	Route::get('/create_documento_plan_director','DocumentoPlanDirectorController@render_create_documento_plan_director');
	Route::post('/submit_create_documento_plan_director','DocumentoPlanDirectorController@submit_create_documento_plan_director');
	Route::get('/search_documento_plan_director','DocumentoPlanDirectorController@search_documento_plan_director');
	Route::get('/download_documento/{id}','DocumentoPlanDirectorController@download_documento');
	Route::post('/submit_disable_documento_plan_director','DocumentoPlanDirectorController@submit_disable_documento_plan_director');
	Route::post('/submit_enable_documento_plan_director','DocumentoPlanDirectorController@submit_enable_documento_plan_director');
});

/* Programacion de Reportes */
Route::group(array('prefix'=>'programacion_reportes','before'=>'auth'),function(){
	Route::get('/list_programacion_reportes','ProgramacionReportesController@list_programacion_reportes');
	Route::get('/search_programacion_reportes','ProgramacionReportesController@search_programacion_reportes');
	Route::get('/create_programacion_reportes','ProgramacionReportesController@render_create_programacion_reportes');
	Route::post('/submit_create_programacion_reporte_cn','ProgramacionReportesController@submit_create_programacion_reporte_cn');
	Route::post('/submit_create_programacion_reporte_etes','ProgramacionReportesController@submit_create_programacion_reporte_etes');
	Route::post('/submit_create_programacion_reporte_paac','ProgramacionReportesController@submit_create_programacion_reporte_paac');
	Route::post('/return_area/{postData}','ProgramacionReportesController@return_area');
	Route::post('/return_programacion_cn/{postData}','ProgramacionReportesController@return_programacion_cn');
	Route::post('/return_programacion_etes/{postData}','ProgramacionReportesController@return_programacion_etes');
	Route::post('/return_programacion_paac/{postData}','ProgramacionReportesController@return_programacion_paac');
});

/*Registro Historico de OTM*/
Route::group(array('prefix'=>'registro_historico_otm','before'=>'auth'),function(){
	Route::get('/list_ot','RegistroHistoricoOTController@list_ot');
	Route::get('/search_ot','RegistroHistoricoOTController@search_ot');
});

/*SOT Busqueda Informacion*/
Route::group(array('prefix'=>'solicitud_busqueda_informacion','before'=>'auth'),function(){
	Route::get('/create_sot','SotBusquedaInformacionController@render_create_sot');
	Route::post('/submit_sot','SotBusquedaInformacionController@submit_create_sot');
	Route::get('/list_busqueda_informacion','SotBusquedaInformacionController@list_busqueda_informacion');
	Route::post('/submit_create_ot_busqueda_informacion','SotBusquedaInformacionController@submit_ot');
	Route::get('/edit_sot_busqueda_informacion/{id}','SotBusquedaInformacionController@render_edit_sot');
	Route::get('/view_sot_busqueda_informacion/{id}','SotBusquedaInformacionController@render_view_sot');
	Route::post('/submit_edit_sot','SotBusquedaInformacionController@submit_edit_sot');
	Route::post('/submit_disable_sot','SotBusquedaInformacionController@submit_disable_sot');	
});

/* Búsqueda Informacion */
Route::group(array('prefix'=>'busqueda_informacion','before'=>'auth'),function(){
	Route::get('/programacion','OtBusquedaInformacionController@render_program_ot_busqueda_informacion');
	Route::post('/submit_programacion','OtBusquedaInformacionController@submit_program_ot_busqueda_informacion');
	Route::post('/submit_create_ot','OtBusquedaInformacionController@submit_create_ot');
	Route::get('/search_ot_busqueda_informacion','OtBusquedaInformacionController@search_ot_busqueda_informacion');
	Route::get('/create_ot_busqueda_informacion/{id}','OtBusquedaInformacionController@render_create_ot');
	Route::post('/submit_create_tarea_ajax','OtBusquedaInformacionController@submit_create_tarea_ajax');
	Route::post('/submit_marcar_tarea_ajax','OtBusquedaInformacionController@submit_marcar_tarea_ajax');
	Route::post('/submit_delete_tarea_ajax','OtBusquedaInformacionController@submit_delete_tarea_ajax');
	Route::post('/submit_create_personal_ajax','OtBusquedaInformacionController@submit_create_personal_ajax');
	Route::post('/submit_delete_personal_ajax','OtBusquedaInformacionController@submit_delete_personal_ajax');	
	Route::post('/export_pdf','OtBusquedaInformacionController@export_pdf');
	Route::get('/view_ot_busqueda_informacion/{id}','OtBusquedaInformacionController@render_view_ot');
	Route::post('/submit_disable_busqueda','OtBusquedaInformacionController@submit_disable_ot');
});

/* Investigacion */
Route::group(array('prefix'=>'investigacion', 'before'=>'auth'),function(){
	Route::get('/','InvestigacionController@home');
});

/* Repositorio de documentos de investigacion */
Route::group(array('prefix'=>'documento_investigacion', 'before'=>'auth'),function(){
	Route::get('/list_documentos','DocumentosInvestigacionController@list_documentos');
	Route::get('/create_documento','DocumentosInvestigacionController@render_create_documento');
	Route::post('/create_documento','DocumentosInvestigacionController@submit_create_documento');
	Route::get('/search_documento','DocumentosInvestigacionController@search_documento');
	Route::get('/edit_documento/{id}','DocumentosInvestigacionController@render_edit_documento');
	Route::post('/submit_edit_documento','DocumentosInvestigacionController@submit_edit_documento');
	Route::post('/download_documento','DocumentosInvestigacionController@download_documento');
	Route::post('/submit_disable_documento','DocumentosInvestigacionController@submit_disable_documento');
	Route::post('/submit_enable_documento','DocumentosInvestigacionController@submit_enable_documento');	
});

/* Plantillas de inspecciones de servicios*/
Route::group(array('prefix'=>'plantillas_servicios', 'before'=>'auth'),function(){
	Route::get('/list_servicios','PlantillasServiciosController@list_servicios');
	Route::get('/search_servicio','PlantillasServiciosController@search_servicio');
	Route::get('/show_servicio/{id}','PlantillasServiciosController@show_servicio');
	Route::get('/create_servicio/{id}','PlantillasServiciosController@render_create_servicio');
	Route::post('/create_servicio/{id}','PlantillasServiciosController@submit_create_servicio');
});

/* Plantillas de mantenimiento preventivo por TS*/
Route::group(array('prefix'=>'plantillas_mant_preventivo', 'before'=>'auth'),function(){
	Route::get('/list_mantenimientos','PlantillasMantenimientoPrevController@list_mantenimientos');
	Route::get('/search_mantenimiento','PlantillasMantenimientoPrevController@search_mantenimiento');
	Route::get('/show_mantenimiento/{id}','PlantillasMantenimientoPrevController@show_mantenimiento');
	Route::get('/create_mantenimiento/{id}','PlantillasMantenimientoPrevController@render_create_mantenimiento');
	Route::post('/create_mantenimiento/{id}','PlantillasMantenimientoPrevController@submit_create_mantenimiento');
});

/* Guias de practica de tecnologias de salud */
Route::group(array('prefix'=>'guias_tecno_salud', 'before'=>'auth'),function(){
	Route::get('/list_guias','GuiasTecnoSaludController@list_guias');
	Route::get('/search_guia','GuiasTecnoSaludController@search_guia');
	Route::get('/create_guia/{id}','GuiasTecnoSaludController@render_create_guia');
	Route::post('/create_guia_submit','GuiasTecnoSaludController@submit_create_guia');
	Route::get('/edit_guia/{id}','GuiasTecnoSaludController@render_edit_guia');
	Route::post('/edit_guia/{id}','GuiasTecnoSaludController@submit_edit_guia');
	Route::post('/download_guia','GuiasTecnoSaludController@download_guia');
	Route::post('/submit_disable_guia','GuiasTecnoSaludController@submit_disable_guia');
	Route::post('/submit_enable_guia','GuiasTecnoSaludController@submit_enable_guia');	
});

/* Guias de practicas clinicas GPC */
Route::group(array('prefix'=>'guias_clinica_gpc', 'before'=>'auth'),function(){
	Route::get('/list_guias','GuiasClinicaGpcController@list_guias');
	Route::get('/search_guia','GuiasClinicaGpcController@search_guia');
	Route::get('/create_guia/{id}','GuiasClinicaGpcController@render_create_guia');
	Route::post('/create_guia_submit','GuiasClinicaGpcController@submit_create_guia');
	Route::get('/edit_guia/{id}','GuiasClinicaGpcController@render_edit_guia');
	Route::post('/edit_guia/{id}','GuiasClinicaGpcController@submit_edit_guia');
	Route::post('/download_guia','GuiasClinicaGpcController@download_guia');
	Route::post('/submit_disable_guia','GuiasClinicaGpcController@submit_disable_guia');
	Route::post('/submit_enable_guia','GuiasClinicaGpcController@submit_enable_guia');	
});

/* Mapa de procesos y procedimientos GTS */
Route::group(array('prefix'=>'mapa_procesos', 'before'=>'auth'),function(){
	Route::get('/list_procesos','MapaProcesosController@list_procesos');
	Route::get('/search_proceso','MapaProcesosController@search_proceso');
	Route::get('/create_proceso','MapaProcesosController@render_create_proceso');
	Route::post('/create_proceso','MapaProcesosController@submit_create_proceso');
	Route::get('/edit_proceso/{id}','MapaProcesosController@render_edit_proceso');
	Route::post('/edit_proceso/{id}','MapaProcesosController@submit_edit_proceso');
	Route::post('/download_proceso','MapaProcesosController@download_proceso');
	Route::post('/submit_disable_proceso','MapaProcesosController@submit_disable_proceso');
	Route::post('/submit_enable_proceso','MapaProcesosController@submit_enable_proceso');	
});

/* Programacion de guias y ETES */
Route::group(array('prefix'=>'programacion_guias','before'=>'auth'),function(){
	Route::get('/list_programacion_guias','ProgramacionGuiasController@list_programacion_guias');
	Route::get('/search_programacion_guias','ProgramacionGuiasController@search_programacion_guias');
	Route::get('/create_programacion_guias','ProgramacionGuiasController@render_create_programacion_guias');
	Route::post('/submit_create_programacion_guia_ts','ProgramacionGuiasController@submit_create_programacion_reporte_ts');
	Route::post('/submit_create_programacion_reporte_etes','ProgramacionReportesController@submit_create_programacion_reporte_etes');
	Route::post('/submit_create_programacion_guia_gpc','ProgramacionGuiasController@submit_create_programacion_reporte_gpc');
	Route::get('/test','TestController@index');
});

/* Reporte financiamiento */
Route::group(array('prefix'=>'reporte_financiamiento','before'=>'auth'),function(){
	//Route::get('/list_programacion_guias','ProgramacionGuiasController@list_programacion_guias');
	//Route::get('/search_programacion_guias','ProgramacionGuiasController@search_programacion_guias');
	Route::get('/create',['uses'=>'ReporteFinanciamientoController@create','as'=>'reporte_financiamiento.create']);
	Route::post('/create',['uses'=>'ReporteFinanciamientoController@store','as'=>'reporte_financiamiento.store']);
	//Route::post('/submit_create_programacion_guia_ts','ProgramacionGuiasController@submit_create_programacion_reporte_ts');
	//Route::post('/submit_create_programacion_reporte_etes','ProgramacionReportesController@submit_create_programacion_reporte_etes');
	//Route::post('/submit_create_programacion_guia_gpc','ProgramacionGuiasController@submit_create_programacion_reporte_gpc');
});

/* Adquisicion */
Route::group(array('prefix'=>'adquisicion', 'before'=>'auth'),function(){
	Route::get('/','AdquisicionController@home');
});

/* Riesgos */
Route::group(array('prefix'=>'riesgos', 'before'=>'auth'),function(){
	Route::get('/','RiesgosController@home');
});

/* RRHH */
Route::group(array('prefix'=>'rrhh', 'before'=>'auth'),function(){
	Route::get('/','RRHHController@home');
});
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoVerifMetrologica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idot_vmetrologica';
	protected $table = 'ot_vmetrologicas';

	public function scopeSearchOtById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ordenes_trabajos.idestado')
			  ->join('servicios','servicios.idservicio','=','ordenes_trabajos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('ordenes_trabajosxactivos','ordenes_trabajosxactivos.idorden_trabajoxactivo','=','ordenes_trabajos.idordenes_trabajo')
			  ->join('activos','activos.idactivo','=','ordenes_trabajosxactivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')

			  /*
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
				*/
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users as elaborador','elaborador.id','=','ordenes_trabajos.id_usuarioelaborado')
			  ->join('users as ingeniero','ingeniero.id','=','grupos.id_responsable')
			  ->join('users as solicitante','solicitante.id','=','grupos.id_responsable')
			  ->join('solicitud_orden_trabajos','solicitud_orden_trabajos.idsolicitud_orden_trabajo','=','ordenes_trabajos.idsolicitud_orden_trabajo')
			  ->where('ordenes_trabajos.idordenes_trabajo','=',$search_criteria)
			  ->select('solicitud_orden_trabajos.fecha_solicitud','activos.garantia','activos.idactivo','activos.numero_serie','activos.codigo_patrimonial','marcas.nombre as nombre_marca','familia_activos.nombre_equipo','modelo_activos.nombre as modelo','ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','elaborador.nombre as nombre_elaborador','elaborador.apellido_pat as apat_elaborador','elaborador.apellido_mat as amat_elaborador','ingeniero.nombre as nombre_ingeniero','ingeniero.apellido_pat as apat_ingeniero','ingeniero.apellido_mat as amat_ingeniero','solicitante.nombre as nombre_solicitante','solicitante.apellido_pat as apat_solicitante','solicitante.apellido_mat as amat_solicitante','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ordenes_trabajos.*');
	  	return $query;
	}


	public function scopeGetLastOtVerifMetrologica($query)
	{
		$query->orderBy('idot_vmetrologica','desc');
	  	return $query;
	}

	public function scopeGetOtsVerifMetrologicaInfo($query)
	{
		$query->join('estados','estados.idestado','=','ot_vmetrologicas.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_vmetrologicas.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_vmetrologicas.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users','users.id','=','grupos.id_responsable')
			  ->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_vmetrologicas.*');
	  	return $query;
	}
	
	public function scopeSearchOtsVerifMetrologica($query,$search_ing,$search_cod_pat,$search_ubicacion,$search_ot,$search_equipo,$search_proveedor,$search_servicio,$search_ini,$search_fin)
	{
		$query->join('estados','estados.idestado','=','ot_vmetrologicas.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_vmetrologicas.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_vmetrologicas.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users','users.id','=','grupos.id_responsable')
			  ->whereNested(function($query) use($search_ing){
			  		$query->where('users.nombre','LIKE',"%$search_ing%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_ing%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_ing%");
			  });
			  if($search_cod_pat!="")
			  	$query->where('activos.codigo_patrimonial','=',$search_cod_pat);
			  if($search_ot!="")
			  	$query->where(DB::raw("CONCAT(ot_vmetrologicas.ot_tipo_abreviatura,ot_vmetrologicas.ot_correlativo,ot_vmetrologicas.ot_activo_abreviatura)"),'LIKE',"%$search_ot%");
			  if($search_equipo!="")
			  	$query->where('familia_activos.nombre_equipo','=',$search_equipo);
			  if($search_ubicacion!="")
			  	$query->where('ubicacion_fisicas.nombre','=',$search_ubicacion);
			  if($search_proveedor!="")
			  	$query->whereNested(function($query) use($search_proveedor){
			  			$query->where('proveedores.ruc','LIKE',"%$search_proveedor%")
			  			  	  ->orWhere('proveedores.razon_social','LIKE',"%$search_proveedor%")
			  			  	  ->orWhere('proveedores.nombre_contacto','LIKE',"%$search_proveedor%");
			  	});
			  if($search_ini != "")
				$query->where('ot_vmetrologicas.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  if($search_fin != "")
				$query->where('ot_vmetrologicas.fecha_programacion','<=',date('Y-m-d H:i:s',strtotime($search_fin)));
			  if($search_servicio!=0)
			  	$query->where('ot_vmetrologicas.idservicio','=',$search_servicio);
			  $query->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_vmetrologicas.*');
	  	return $query;
	}

	public function scopeSearchOtVerifMetrologicaById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ot_vmetrologicas.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_vmetrologicas.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_vmetrologicas.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users as elaborador','elaborador.id','=','ot_vmetrologicas.id_usuarioelaborador')
			  ->join('users as solicitante','solicitante.id','=','grupos.id_responsable')
			  ->where('ot_vmetrologicas.idot_vmetrologica','=',$search_criteria)
			  ->select('activos.garantia','activos.idactivo','activos.numero_serie','activos.codigo_patrimonial','marcas.nombre as nombre_marca','familia_activos.nombre_equipo','modelo_activos.nombre as modelo','ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','elaborador.nombre as nombre_elaborador','elaborador.apellido_pat as apat_elaborador','elaborador.apellido_mat as amat_elaborador','solicitante.nombre as nombre_solicitante','solicitante.apellido_pat as apat_solicitante','solicitante.apellido_mat as amat_solicitante','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_vmetrologicas.*');
	  	return $query;
	}

	public function scopeGetOtXPeriodo($query,$idestado,$fecha_ini,$fecha_fin)
	{
		$query->where('idestado_ot','=',$idestado)
			  ->where('fecha_programacion','>=',$fecha_ini)
			  ->where('fecha_programacion','<=',$fecha_fin);
		return $query;
	}

	public function scopeGetOtXPeriodoXActivo($query,$idestado,$fecha_ini,$fecha_fin,$idactivo)
	{
		$query->where('idestado_ot','=',$idestado)
			  ->where('fecha_programacion','>=',$fecha_ini)
			  ->where('fecha_programacion','<=',$fecha_fin)
			  ->where('idactivo','=',$idactivo);
		return $query;
	}

}
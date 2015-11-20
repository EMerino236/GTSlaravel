<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_busqueda_infos';
	protected $primaryKey = 'idot_busqueda_info';

	
	public function scopeGetOtsBusquedaInfo($query)
	{
		$query->join('estados','estados.idestado','=','ot_busqueda_infos.idestado_ot')
			  ->join('areas','areas.idarea','=','ot_busqueda_infos.idarea')
			  ->join('users','users.id','=','ot_busqueda_infos.id_usuariosolicitante')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','ot_busqueda_infos.idtipo_busqueda_info')
			  ->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
	  	return $query;
	}


	public function scopeSearchOtsBusquedaInformacion($query,$search_tipo,$search_area,$search_encargado,$search_ot,$search_ini)
	{
		$query->join('estados','estados.idestado','=','ot_busqueda_infos.idestado_ot')
			  ->join('areas','areas.idarea','=','ot_busqueda_infos.idarea')
			  ->join('users','users.id','=','ot_busqueda_infos.id_usuariosolicitante')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','ot_busqueda_infos.idtipo_busqueda_info')
			  ->whereNested(function($query) use($search_encargado){
			  		$query->where('users.nombre','LIKE',"%$search_encargado%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_encargado%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_encargado%");
			  });
			  if($search_tipo!=0)
			  	$query->where('tipo_busqueda_infos.idtipo_busqueda_info','=',$search_tipo);
			  if($search_ot!="")
			  	$query->where(DB::raw("CONCAT(ot_busqueda_infos.ot_tipo_abreviatura,ot_busqueda_infos.ot_correlativo)"),'LIKE',"%$search_ot%");
			  if($search_area!=0)
			  	$query->where('areas.idarea','=',$search_area);			 
			  if($search_ini != "")
				$query->where('ot_busqueda_infos.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  
			  $query->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
	  	return $query;
	}

	public function scopeGetLastOtBusqueda($query)
	{
		$query->orderBy('idot_busqueda_info','desc');
	  	return $query;
	}

	/*public function scopeSearchOtPreventivoById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ot_preventivos.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_preventivos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_preventivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users as elaborador','elaborador.id','=','ot_preventivos.id_usuarioelaborador')
			  ->join('users as ingeniero','ingeniero.id','=','grupos.id_responsable')
			  ->join('users as solicitante','solicitante.id','=','grupos.id_responsable')
			  ->where('ot_preventivos.idot_preventivo','=',$search_criteria)
			  ->select('activos.garantia','activos.idactivo','activos.numero_serie','activos.codigo_patrimonial','marcas.nombre as nombre_marca','familia_activos.nombre_equipo','modelo_activos.nombre as modelo','ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','elaborador.nombre as nombre_elaborador','elaborador.apellido_pat as apat_elaborador','elaborador.apellido_mat as amat_elaborador','ingeniero.nombre as nombre_ingeniero','ingeniero.apellido_pat as apat_ingeniero','ingeniero.apellido_mat as amat_ingeniero','solicitante.nombre as nombre_solicitante','solicitante.apellido_pat as apat_solicitante','solicitante.apellido_mat as amat_solicitante','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_preventivos.*');
	  	return $query;
	}

	public function scopeGetOtXPeriodo($query,$idestado,$fecha_ini,$fecha_fin)
	{
		$query->where('ot_preventivos.idestado_ot','=',$idestado)
			  ->where('ot_preventivos.fecha_programacion','>=',$fecha_ini)
			  ->where('ot_preventivos.fecha_programacion','<=',$fecha_fin)
			  ->select('ot_preventivos.fecha_programacion','ot_preventivos.idot_preventivo','ot_preventivos.*');
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

	public function scopeGetOtsMantPreventivoAllHistorico($query)
	{
		$query->join('estados','estados.idestado','=','ot_preventivos.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_preventivos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_preventivos.idactivo')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')			  
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->select('activos.codigo_patrimonial as codigo_patrimonial','activos.numero_serie as serie','proveedores.razon_social as nombre_proveedor','ubicacion_fisicas.nombre as nombre_ubicacion','marcas.nombre as nombre_marca','familia_activos.nombre_equipo as nombre_equipo','modelo_activos.nombre as nombre_modelo','areas.nombre as nombre_area','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','grupos.nombre as nombre_grupo','ot_preventivos.*');
	  	return $query;
	}

	public function scopeSearchOTHistorico($query,$search_nombre_equipo,$search_marca,$search_modelo,$search_grupo,$search_serie,$search_proveedor,$search_codigo_patrimonial,$search_ini,$search_fin)
	{
		$query->join('estados','estados.idestado','=','ot_preventivos.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_preventivos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_preventivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo');			  
			  if($search_nombre_equipo!="")
			  	$query->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  if($search_marca!=0)
			  	$query->where('marcas.idmarca','=',$search_marca);
			  if($search_modelo!="")
			  	$query->where('modelo_activos.nombre','LIKE',"%$search_modelo%");
			  if($search_grupo!="")
			  	$query->where('grupos.nombre','LIKE',"%$search_grupo%");
			  if($search_serie!="")
			  	$query->where('activos.numero_serie','LIKE',"%$search_serie%");
			  if($search_codigo_patrimonial!="")
			  	$query->where('activos.codigo_patrimonial','LIKE',"%$search_codigo_patrimonial%");
			  if($search_proveedor!="")
			  	$query->whereNested(function($query) use($search_proveedor){
			  			$query->where('proveedores.ruc','LIKE',"%$search_proveedor%")
			  			  	  ->orWhere('proveedores.razon_social','LIKE',"%$search_proveedor%")
			  			  	  ->orWhere('proveedores.nombre_contacto','LIKE',"%$search_proveedor%");
			  	});
			  if($search_ini != "")
				$query->where('ot_preventivos.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  if($search_fin != "")
				$query->where('ot_preventivos.fecha_programacion','<=',date('Y-m-d H:i:s',strtotime($search_fin)));
			  $query->select('activos.codigo_patrimonial as codigo_patrimonial','activos.numero_serie as serie','proveedores.razon_social as nombre_proveedor','ubicacion_fisicas.nombre as nombre_ubicacion','marcas.nombre as nombre_marca','familia_activos.nombre_equipo as nombre_equipo','modelo_activos.nombre as nombre_modelo','areas.nombre as nombre_area','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','grupos.nombre as nombre_grupo','ot_preventivos.*');
	  	return $query;
	}*/
	
}
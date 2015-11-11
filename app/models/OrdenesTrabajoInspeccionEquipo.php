<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoInspeccionEquipo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_inspec_equipos';
	protected $primaryKey = 'idot_inspec_equipo';

	
	public function scopeGetOtsInspecEquipoInfo($query)
	{
		$query->join('estados','estados.idestado','=','ot_inspec_equipos.idestado')
			  ->join('servicios','servicios.idservicio','=','ot_inspec_equipos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('users','users.id','=','ot_inspec_equipos.id_ingeniero')
			  ->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_inspec_equipos.*');
	  	return $query;
	}


	/*public function scopeSearchOtsMantPreventivo($query,$search_ing,$search_cod_pat,$search_ubicacion,$search_ot,$search_equipo,$search_proveedor,$search_ini,$search_fin,$search_servicio)
	{
		$query->join('estados','estados.idestado','=','ot_preventivos.idestado_ot')
			  ->join('servicios','servicios.idservicio','=','ot_preventivos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('activos','activos.idactivo','=','ot_preventivos.idactivo')
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
			  	$query->where(DB::raw("CONCAT(ot_preventivos.ot_tipo_abreviatura,ot_preventivos.ot_correlativo,ot_preventivos.ot_activo_abreviatura)"),'LIKE',"%$search_ot%");
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
				$query->where('ot_preventivos.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  if($search_fin != "")
				$query->where('ot_preventivos.fecha_programacion','<=',date('Y-m-d H:i:s',strtotime($search_fin)));
			  if($search_servicio!=0)
			  	$query->where('ot_preventivos.idservicio','=',$search_servicio);
			  $query->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_preventivos.*');
	  	return $query;
	}*/

	public function scopeGetLastOtInspeccionEquipo($query)
	{
		$query->orderBy('created_at','desc');
	  	return $query;
	}

	public function scopeSearchOtInspeccionEquipoById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ot_inspec_equipos.idestado')
			  ->join('servicios','servicios.idservicio','=','ot_inspec_equipos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('users as ingeniero','ingeniero.id','=','ot_inspec_equipos.id_ingeniero')
			  ->where('ot_inspec_equipos.idot_inspec_equipo','=',$search_criteria)
			  ->select('areas.nombre as nombre_area','ingeniero.nombre as nombre_ingeniero','ingeniero.apellido_pat as apat_ingeniero','ingeniero.apellido_mat as amat_ingeniero','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ot_inspec_equipos.*');
	  	return $query;
	}

	public function scopeGetOtXPeriodo($query,$idestado,$fecha_ini,$fecha_fin)
	{
		$query->where('idestado','=',$idestado)
			  ->where('fecha_inicio','>=',$fecha_ini)
			  ->where('fecha_inicio','<=',$fecha_fin)
			  ->select('ot_inspec_equipos.fecha_inicio','ot_inspec_equipos.idot_inspec_equipo','ot_inspec_equipos.*');
		return $query;
	}

	public function scopeGetOtXPeriodoXServicio($query,$idestado,$fecha_ini,$fecha_fin,$idservicio)
	{
		$query->where('idestado','=',$idestado)
			  ->where('fecha_inicio','>=',$fecha_ini)
			  ->where('fecha_inicio','<=',$fecha_fin)
			  ->where('idservicio','=',$idservicio);
		return $query;
	}
	
}
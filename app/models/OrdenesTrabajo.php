<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idordenes_trabajo';

	public function scopeGetOtsMantCorrectivoInfo($query)
	{
		$query->join('estados','estados.idestado','=','ordenes_trabajos.idestado')
			  ->join('servicios','servicios.idservicio','=','ordenes_trabajos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('ordenes_trabajosxactivos','ordenes_trabajosxactivos.idorden_trabajoxactivo','=','ordenes_trabajos.idordenes_trabajo')
			  ->join('activos','activos.idactivo','=','ordenes_trabajosxactivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users','users.id','=','grupos.id_responsable')
			  ->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ordenes_trabajos.*');
	  	return $query;
	}

	public function scopeSearchOtsMantCorrectivo($query,$search_ing,$search_cod_pat,$search_ubicacion,$search_ot,$search_equipo,$search_proveedor,$search_ini,$search_fin)
	{
		$query->join('estados','estados.idestado','=','ordenes_trabajos.idestado')
			  ->join('servicios','servicios.idservicio','=','ordenes_trabajos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('ordenes_trabajosxactivos','ordenes_trabajosxactivos.idorden_trabajoxactivo','=','ordenes_trabajos.idordenes_trabajo')
			  ->join('activos','activos.idactivo','=','ordenes_trabajosxactivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
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
			  	$query->where('ordenes_trabajos.idordenes_trabajo','=',$search_ot);
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
				$query->where('ordenes_trabajos.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  if($search_fin != "")
				$query->where('ordenes_trabajos.fecha_programacion','<=',date('Y-m-d H:i:s',strtotime($search_fin)));
			  $query->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ordenes_trabajos.*');
	  	return $query;
	}

	public function scopeSearchOtsById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ordenes_trabajos.idestado')
			  ->join('servicios','servicios.idservicio','=','ordenes_trabajos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('ordenes_trabajosxactivos','ordenes_trabajosxactivos.idorden_trabajoxactivo','=','ordenes_trabajos.idordenes_trabajo')
			  ->join('activos','activos.idactivo','=','ordenes_trabajosxactivos.idactivo')
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('users','users.id','=','grupos.id_responsable')
			  ->where('ordenes_trabajos.idordenes_trabajo','=',$search_criteria)
			  ->select('ubicacion_fisicas.nombre as nombre_ubicacion','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','servicios.nombre as nombre_servicio','estados.nombre as nombre_estado','ordenes_trabajos.*');
	  	return $query;
	}

}
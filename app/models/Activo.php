<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Activo extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'activos';
	protected $primaryKey = 'idactivo';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function scopeGetActivosInfo($query)
	{
		$query->withTrashed()
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('servicios','servicios.idservicio','=','ubicacion_fisicas.idubicacion_fisica')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->select('servicios.nombre as nombre_servicio','ubicacion_fisicas.nombre as nombre_ubicacion_fisica','grupos.nombre as nombre_grupo','familia_activos.nombre_equipo as nombre_equipo',
			  		   'familia_activos.modelo as activo_modelo','marcas.nombre as nombre_marca','proveedores.razon_social as nombre_proveedor','activos.*');
		return $query;
	}

	public function scopesearchActivos($query,$search_grupo,$search_servico,$search_ubicacion,$search_nombre_equipo,$search_marca,$search_modelo,
									$search_serie, $search_proveedor,$search_codigo_compra,$search_codigo_patrimonial)
	{
		$query->withTrashed()
			  ->join('ubicacion_fisicas','ubicacion_fisicas.idubicacion_fisica','=','activos.idubicacion_fisica')
			  ->join('servicios','servicios.idservicio','=','ubicacion_fisicas.idubicacion_fisica')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor');
			  
			  if($search_grupo != '0')
			  {
			  	$query->where('activos.idgrupo','=',$search_grupo);
			  }

			  if($search_servico != '0')
			  {
			  	$query->where('activos.idservicio','=',$search_servico);
			  }

			  if($search_ubicacion != '0')
			  {
			  	$query->where('activos.idubicacion_fisica','=',$search_ubicacion);
			  }

			  if($search_nombre_equipo != "")
			  {
			  	$query->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  }

			  if($search_marca != '0')
			  {
			  	$query->where('familia_activos.idmarca','=',$search_marca);
			  }

			  if($search_modelo != "")
			  {
			  	$query->where('familia_activos.modelo','LIKE',"%$search_modelo%");
			  }

			  if($search_serie != "")
			  {
			  	$query->where('activos.numero_serie','LIKE',"%$search_serie%");
			  }

			  if($search_proveedor != "0")
			  {
			  	$query->where('activos.idproveedor','=',$search_proveedor);
			  }

			  if($search_codigo_compra != "")
			  {
			  	$query->where('activos.codigo_compra','LIKE',"%$search_codigo_compra%");
			  }

			  if($search_codigo_patrimonial != "")
			  {
			  	$query->where('activos.codigo_patrimonial','LIKE',"%$search_codigo_patrimonial%");
			  }


			  $query->select('servicios.nombre as nombre_servicio','ubicacion_fisicas.nombre as nombre_ubicacion_fisica','grupos.nombre as nombre_grupo','familia_activos.nombre_equipo as nombre_equipo',
			  		   'familia_activos.modelo as activo_modelo','marcas.nombre as nombre_marca','proveedores.razon_social as nombre_proveedor','activos.*');
		return $query;
	}
	

	public function scopeSearchActivosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('activos.idactivo','=',$search_criteria);
		return $query;
	}

	public function scopeSearchActivosByCodigoPatrimonial($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('activos.codigo_patrimonial','=',$search_criteria);
		return $query;	
	}

	public function scopeGetActivosByGrupoId($query,$search_criteria){
		$query->withTrashed()
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('activos.idgrupo','LIKE',"%$search_criteria%");
			  })
			  ->select('familia_activos.nombre_equipo as nombre_equipo','activos.*');
		return $query;
	}
	
	public function scopeGetActivosByServicioId($query,$search_criteria){
		$query->withTrashed()
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','activos.idfamilia_activo')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('activos.idservicio','LIKE',"%$search_criteria%");
			  })
			  ->select('familia_activos.nombre_equipo as nombre_equipo','activos.*');
		return $query;
	}

	public function scopeGetEquiposActivosByServicioId($query,$idservicio){
		$query->whereNested(function($query) use($idservicio){
			  		$query->where('idservicio','LIKE',"%$idservicio%");
			  })
			  ->select('activos.*');
		return $query;
	}

	public function scopeGetEquiposActivosByGrupoId($query,$idgrupo){
		$query->whereNested(function($query) use($idgrupo){
			  		$query->where('idgrupo','LIKE',"%$idgrupo%");
			  })
			  ->select('activos.*');
		return $query;
	}

	

}

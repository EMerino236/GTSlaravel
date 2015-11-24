<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoInspeccionEquipoxActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_inspec_equiposxactivos';
	protected $primaryKey = 'idot_inspec_equiposxactivo';

	public function scopeGetOtInspeccionxActivo($query,$idot_inspec_equipo,$idactivo)
	{
		$query->join('activos','activos.idactivo','=','ot_inspec_equiposxactivos.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')			  
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->where('ot_inspec_equiposxactivos.idot_inspec_equipo','=',$idot_inspec_equipo)
			  ->where('ot_inspec_equiposxactivos.idactivo','=',$idactivo)
			  ->select('activos.codigo_patrimonial as codigo_patrimonial','modelo_activos.nombre as nombre_modelo','familia_activos.nombre_equipo as nombre_equipo','ot_inspec_equiposxactivos.*');	
			 
		return $query;
	}

	public function scopeGetOtInspeccionxActivoByIdOtInspeccion($query,$idot_inspec_equipo)
	{
		$query->join('activos','activos.idactivo','=','ot_inspec_equiposxactivos.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')			  
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->where('ot_inspec_equiposxactivos.idot_inspec_equipo','=',$idot_inspec_equipo)
			  ->select('activos.codigo_patrimonial as codigo_patrimonial','modelo_activos.nombre as nombre_modelo','familia_activos.nombre_equipo as nombre_equipo','ot_inspec_equiposxactivos.*');	
		return $query;
	}

	

}
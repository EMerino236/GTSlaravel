<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Proveedor extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'proveedores';
	protected $primaryKey = 'idproveedor';

	public function scopeGetProveedoresInfo($query)
	{
		$query->withTrashed()
			  ->join('estados','estados.idestado','=','proveedores.idestado')
			  ->select('estados.nombre as nombre_estado','proveedores.*');
		return $query;
	}

	public function scopeSearchProveedorById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('proveedores.idproveedor','=',$search_criteria);
		return $query;
	}

	public function scopeSearchProveedores($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('estados','estados.idestado','=','proveedores.idestado')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('proveedores.ruc','LIKE',"%$search_criteria%")
			  			  ->orWhere('proveedores.razon_social','LIKE',"%$search_criteria%")
			  			  ->orWhere('proveedores.telefono','LIKE',"%$search_criteria%")
			  			  ->orWhere('proveedores.email','LIKE',"%$search_criteria%");
			  })
			  ->select('estados.nombre as nombre_estado','proveedores.*');
		return $query;
	}
}
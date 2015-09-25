<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Poveedor extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'proveedores';

	public function scopeGetProveedoresInfo($query)
	{
		$query->withTrashed()
			  ->join('estados','estados.idestado','=','proveedores.idestado')
			  ->select('estados.nombre as nombre_estado','proveedores.*');
		return $query;
	}
}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Tabla extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	public function scopeGetTablaByNombre($query,$nombre_tabla)
	{
		$query->withTrashed()
			  ->where('nombre_tabla','=',$nombre_tabla);
		return $query;
	}

}
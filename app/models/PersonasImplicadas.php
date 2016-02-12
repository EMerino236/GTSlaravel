<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonasImplicadas extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personas_implicadas';

	public function scopeGetTipoByNombre($query,$nombre)
	{
		$query->where('nombre','=',$nombre);
		return $query;
	}
}
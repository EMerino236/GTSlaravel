<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UbicacionFisica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ubicacion_fisicas';
	protected $primaryKey = 'idubicacion_fisica';

	public function scopeSearchUbicacionByServicio($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('ubicacion_fisicas.idservicio',"=",$search_criteria);
		return $query;
	}

}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Area extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="areas";

	public function scopeGetAreasInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_areas','tipo_areas.idtipo_area','=','areas.idtipo_area')
			  ->select('tipo_areas.nombre as nombre_tipo_area','areas.*');
		return $query;
	}

}
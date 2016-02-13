<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EventoxEntornoAsistencial extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'eventoxentorno_asistencial';

	public function scopeSearchEntornoAsistencialByIdEvento($query,$idevento)
	{
		$query->withTrashed()
			  ->join('entorno_asistencial','entorno_asistencial.id','=','eventoxentorno_asistencial.identorno')
			  ->where('eventoxentorno_asistencial.idevento','=',$idevento)
			  ->select('eventoxentorno_asistencial.*','entorno_asistencial.nombre as nombre_tipo');
		return $query;
	}
}
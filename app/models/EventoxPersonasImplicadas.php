<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EventoxPersonasImplicadas extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'eventoxpersonas_implicadas';

	

	public function scopeGetPersonasImplicadasByIdEvento($query,$idevento)
	{
		$query->withTrashed()
			  ->join('eventos_adversos','eventos_adversos.id','=','eventoxpersonas_implicadas.idevento') 			  
			  ->join('personas_implicadas','personas_implicadas.id','=','eventoxpersonas_implicadas.idpersonas_implicada')
			  ->where('eventoxpersonas_implicadas.idevento','=',$idevento)
			  ->select('personas_implicadas.nombre as nombre_tipo','eventoxpersonas_implicadas.*');
		return $query;
	}
}
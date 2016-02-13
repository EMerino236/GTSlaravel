<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EventoxSubTipoHijo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'eventos_adversosxsubtipohijo_incidente';

	public function scopeSearchEventoXSubTiposById($query,$idevento)
	{
		$query->withTrashed()
			  ->join('eventos_adversos','eventos_adversos.id','=','eventos_adversosxsubtipohijo_incidente.idevento') 			  
			  ->join('subtipohijo_incidente','subtipohijo_incidente.id','=','eventos_adversosxsubtipohijo_incidente.idsubtipohijo')
			  ->join('subtipopadre_incidente','subtipopadre_incidente.id','=','subtipohijo_incidente.idsubtipopadre_incidente')
			  ->join('tipo_incidente','tipo_incidente.id','=','subtipopadre_incidente.idtipo_incidente')
			  ->where('eventos_adversosxsubtipohijo_incidente.idevento','=',$idevento)
			  ->select('tipo_incidente.id as idtipo_incidente','subtipopadre_incidente.id as idsubtipopadre_incidente','subtipohijo_incidente.id as idsubtipohijo_incidente','eventos_adversosxsubtipohijo_incidente.*');
		return $query;
	}

	

}
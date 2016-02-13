<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EventoxSubTipoHijoxSubTipoNieto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'eventosxhijoxnieto';

	public function scopeSearchEventoXSubTiposById($query,$ideventoxhijo)
	{
		$query->withTrashed()
			  ->join('subtiponieto_incidente','subtiponieto_incidente.id','=','eventosxhijoxnieto.idsubtiponieto')
			  ->where('eventosxhijoxnieto.ideventoxhijo','=',$ideventoxhijo)
			  ->select('subtiponieto_incidente.id as idsubtiponieto_incidente','eventosxhijoxnieto.*');
		return $query;
	}

}
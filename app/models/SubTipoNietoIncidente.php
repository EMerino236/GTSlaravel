<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SubTipoNietoIncidente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'subtiponieto_incidente';
	
	public function scopeGetSubTiposByIdSubtipoHijo($query,$idsubtipohijo)
	{
		$query->where('idsubtipohijo_incidente','=',$idsubtipohijo);
		return $query;
	}
	
}
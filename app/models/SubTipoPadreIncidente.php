<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SubTipoPadreIncidente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'subtipopadre_incidente';
	
	public function scopeGetSubTiposByIdTipoIncidente($query,$idtipo_incidente)
	{
		$query->where('idtipo_incidente','=',$idtipo_incidente);
		return $query;
	}
	
}
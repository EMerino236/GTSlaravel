<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Consumible extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'consumibles';
	protected $primaryKey = 'idconsumible';

		public function scopeGetConsumibleByModelo($query,$idmodelo_equipo)
	{
		$query->where('consumibles.idmodelo_equipo','=',$idmodelo_equipo);

		return $query;
	}
}
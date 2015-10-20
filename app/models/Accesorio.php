<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Accesorio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'accesorios';
	protected $primaryKey = 'idaccesorio';

	public function scopeGetAccesorioByModelo($query,$idmodelo_equipo)
	{
		$query->where('accesorios.idmodelo_equipo','=',$idmodelo_equipo);
	}
}
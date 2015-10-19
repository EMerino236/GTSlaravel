<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Accesorio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'accesorios';
	protected $primaryKey = 'idaccesorio';

	public function scopeGetAccesorioByModelo($query,$idmodelo)
	{
		$query->withTrashed()
			  ->where('accesorios.idmodelo_equipo','=',$idmodelo);
	}
}
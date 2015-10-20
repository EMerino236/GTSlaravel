<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Componente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'componentes';
	protected $primaryKey = 'idcomponente';

	public function scopeGetComponenteByModelo($query,$idmodelo_equipo)
	{
		$query->withTrashed()
			  ->where('componentes.idmodelo_equipo','=',$idmodelo_equipo);
	}

}
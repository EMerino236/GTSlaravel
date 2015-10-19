<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ModeloActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'modelo_activos';
	protected $primaryKey = 'idmodelo_equipo';

	public function scopeGetModeloByFamiliaActivo($query,$search_idfamilia)
	{
		$query->withTrashed()
			  ->where('modelo_activos.idfamilia_activo','=',$search_idfamilia);
	}
}
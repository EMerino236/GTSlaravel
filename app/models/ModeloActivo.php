<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ModeloActivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'modelo_activos';
	protected $primaryKey = 'idmodelo_equipo';

	public function familiaActivo()
	{
		return $this->belongsTo('familiaActivo','idfamilia_activo');
	}	

	public function scopeGetModeloByFamiliaActivo($query,$search_idfamilia)
	{
		$query->where('modelo_activos.idfamilia_activo','=',$search_idfamilia);
	}
	
}
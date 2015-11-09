<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Estado extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idestado';

	public function scopeGetEstadosByNombreTabla($query,$nombre_tabla)
	{
		$query->join('tablas','tablas.idtabla','=','estados.idtabla')
			  ->where('tablas.nombre','=',$nombre_tabla)
			  ->select('estados.nombre','estados.idestado');
		return $query;
	}

	public function scopeGetEstadoById($query,$idestado){
		$query->where('idestado','=',$idestado);
		return $query;
	}

}
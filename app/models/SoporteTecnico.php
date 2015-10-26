<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SoporteTecnico extends Eloquent {
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	protected $table = 'soporte_tecnicos';
	protected $primaryKey = 'idsoporte_tecnico';

	public function scopeGetSoportesTecnicoInfo($query)
	{
		$query->join('tipo_doc_identidades','tipo_doc_identidades.idtipo_documento','=','soporte_tecnicos.idtipo_documento')
	 		  ->select('tipo_doc_identidades.nombre as tipo_documento','soporte_tecnicos.*');

	    return $query;
	}
}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalOtBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personal_ot_busqueda_infos';
	protected $primaryKey = 'idpersonal_ot_busqueda_info';

	public function scopeGetPersonalXOt($query,$idot_busqueda_info)
	{
		$query->where('idot_busqueda_info','=',$idot_busqueda_info);
		return $query;
	}

}
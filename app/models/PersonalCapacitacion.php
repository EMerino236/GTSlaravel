<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PersonalCapacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'personal_capacitaciones';

	public function scopeGetPersonalByIdCapacitacion($query,$id_capacitacion){
		$query->join('servicios','servicios.idservicio','=','personal_capacitaciones.id_servicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('tipo_doc_identidades','tipo_doc_identidades.idtipo_documento','=','personal_capacitaciones.id_tipodocumento')
			  ->where('id_capacitacion','=',$id_capacitacion)
			  ->select('tipo_doc_identidades.nombre as nombre_documento','servicios.nombre as nombre_servicio','areas.nombre as nombre_area','personal_capacitaciones.*');
	}

	
}
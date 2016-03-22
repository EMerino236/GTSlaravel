<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ActividadCapacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'actividad_capacitaciones';

	public function scopeGetActividadesByIdSesion($query,$id_sesion){
		$query->join('servicios','servicios.idservicio','=','actividad_capacitaciones.id_servicio')
			  ->where('id_sesion','=',$id_sesion)
			  ->select('servicios.nombre as nombre_servicio','actividad_capacitaciones.*');
	}
	
}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TrabajoCronogramaActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'trabajos_cronograma_actividades';

	public function actividadPrevia()
	{
		return $this->belongsTo('TrabajoCronogramaActividad', 'id_actividad_previa');
	}

	public function cronograma()
	{
		return $this->belongsTo('TrabajoCronograma', 'id_cronograma');
	}

		public function actividadesPosteriores()
	{
		return $this->hasMany('TrabajoCronogramaActividad', 'id_actividad_previa');
	}
}
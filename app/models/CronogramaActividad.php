<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CronogramaActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'cronogramas_actividades';

	public function actividadPrevia()
	{
		return $this->belongsTo('CronogramaActividad', 'id_actividad_previa');
	}

	public function cronograma()
	{
		return $this->belongsTo('Cronograma', 'id_cronograma');
	}

	public function actividadesPosteriores()
	{
		return $this->hasMany('CronogramaActividad', 'id_actividad_previa');
	}

}
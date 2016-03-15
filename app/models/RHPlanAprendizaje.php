<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RHPlanAprendizaje extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'rh_planes_aprendizaje';

	public function servicioClinico()
	{
		return $this->belongsTo('Servicio', 'id_servicio_clinico');
	}

	public function departamento()
	{
		return $this->belongsTo('Area', 'id_departamento');
	}

	public function responsable()
	{
		return $this->belongsTo('User', 'id_responsable');
	}

	public function programacion()
	{
		return $this->belongsTo('ProgramacionInternado', 'id_programacion');
	}

	public function actividades()
	{
		return $this->hasMany('RHPlanActividad', 'id_plan');
	}

	public function recursos()
	{
		return $this->hasMany('RHPlanRecurso', 'id_plan');
	}

}
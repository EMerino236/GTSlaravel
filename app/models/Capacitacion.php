<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Capacitacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'capacitaciones';

	public function servicio()
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

	public function tipo()
	{
		return $this->belongsTo('RHTipo', 'id_tipo');	
	}

	public function modalidad()
	{
		return $this->belongsTo('RHModalidad', 'id_modalidad');	
	}
}
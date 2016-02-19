<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Alcance extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances';

	public function categoria()
	{
		return $this->belongsTo('ProyectoCategoria', 'id_categoria');
	}

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

	public function requerimientos()
	{
		return $this->hasMany('AlcanceRequerimiento', 'id_alcance');
	}

	public function caracteristicas()
	{
		return $this->hasMany('AlcanceCaracteristica', 'id_alcance');
	}

	public function criterios()
	{
		return $this->hasMany('AlcanceCriterio', 'id_alcance');
	}

	public function entregables()
	{
		return $this->hasMany('AlcanceEntregable', 'id_alcance');
	}

	public function exclusiones()
	{
		return $this->hasMany('AlcanceExclusion', 'id_alcance');
	}

	public function restricciones()
	{
		return $this->hasMany('AlcanceRestriccion', 'id_alcance');
	}

	public function asunciones()
	{
		return $this->hasMany('AlcanceAsuncion', 'id_alcance');
	}


}
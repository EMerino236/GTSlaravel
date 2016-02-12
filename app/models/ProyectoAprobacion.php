<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoAprobacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_aprobaciones';

	public function persona()
	{
		return $this->belongsTo('User', 'usuario');
	}
}
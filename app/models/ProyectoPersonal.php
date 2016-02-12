<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProyectoPersonal extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'proyectos_personal';

	public function persona()
	{
		return $this->belongsTo('User', 'usuario');
	}

}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PerfilFormacionAcademica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'perfiles_formaciones_academicas';

	public function pais()
	{
		return $this->belongsTo('Pais', 'id_pais');
	}
}
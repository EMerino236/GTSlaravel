<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PerfilFormacionContinua extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'perfiles_formaciones_continuas';

	public function pais()
	{
		return $this->belongsTo('Pais', 'id_pais');
	}

}
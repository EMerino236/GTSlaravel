<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PerfilIdioma extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'perfiles_idiomas';

	public function nombre()
	{
		return $this->belongsTo('Idioma', 'id_nombre');
	}
}
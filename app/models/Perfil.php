<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Perfil extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'perfiles';

	public function paisNacimiento()
	{
		return $this->belongsTo('Pais', 'id_pais_nacimiento');
	}

	public function paisResidencia()
	{
		return $this->belongsTo('Pais', 'id_pais_residencia');
	}

	public function idiomaMaterno()
	{
		return $this->belongsTo('Idioma', 'id_idioma_materno');
	}

	public function formacionesAcademicas()
	{
		return $this->hasMany('PerfilFormacionAcademica', 'id_perfil');
	}

	public function formacionesContinuas()
	{
		return $this->hasMany('PerfilFormacionContinua', 'id_perfil');
	}

	public function idiomas()
	{
		return $this->hasMany('PerfilIdioma', 'id_perfil');
	}

}
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

	public function getUserFullNameAttribute()
	{
	    return $this->attributes['nombres'] .' '. $this->attributes['apellido_paterno'] . ' ' . $this->attributes['apellido_materno'];
	}

	public function scopeSearchReporte($query,$search_rol,$search_dni,$search_nombre,$search_pais)
	{
		$query->withTrashed();
		
		if($search_rol != -1)
		{
			$query->where('perfiles.id_rol','=',$search_rol);
		}

		if($search_dni != "")
		{
			$query->where('perfiles.dni','LIKE',"%$search_dni%");
		}

		if($search_nombre != "")
		{
			$query->where('perfiles.nombres','LIKE', "%$search_nombre%");
		}

		if($search_pais != 0)
		{
			$query->where('perfiles.id_pais_nacimiento', '=' ,$search_pais);
		}
		
		return $query;
	}
}
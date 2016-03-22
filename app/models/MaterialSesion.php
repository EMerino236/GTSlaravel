<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialSesion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'materiales_sesion';	
	
	public function sesion()
	{
		return $this->belongsTo('Sesion','idsesion');
	}

	public function scopeGetMaterialByIdSesion($query,$idsesion){
		return $query->where('materiales_sesion.idsesion','=',$idsesion);
	}
}
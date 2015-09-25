<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Activo extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'activos';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	

	public function scopeSearchActivosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('activos.idactivo','=',$search_criteria);
		return $query;
	}

	public function scopeSearchActivosByCodigoPatrimonial($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('activos.codigo_patrimonial','=',$search_criteria);
		return $query;	
	}

	

}

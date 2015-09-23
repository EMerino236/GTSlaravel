<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function scopeGetUsersInfo($query)
	{
		$query->withTrashed()
			  ->join('roles','roles.idrol','=','users.idrol')
			  ->join('areas','areas.idarea','=','users.idarea')
			  ->select('roles.nombre as nombre_rol','areas.nombre as nombre_area','users.*');
		return $query;
	}

	public function scopeSearchUserById($query,$search_criteria)
	{
		$query->where('users.id','=',$search_criteria);
		return $query;
	}

}

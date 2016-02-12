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
		$query->withTrashed()
			  ->where('users.id','=',$search_criteria);
		return $query;
	}

	public function scopeSearchUsers($query,$search_criteria,$search_area)
	{
		$query->withTrashed()
			  ->join('roles','roles.idrol','=','users.idrol')
			  ->join('areas','areas.idarea','=','users.idarea')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('users.username','LIKE',"%$search_criteria%")
			  			  ->orWhere('users.nombre','LIKE',"%$search_criteria%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_criteria%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_criteria%");
			  });

			  if($search_area!=0)
			    $query->where('users.idarea','=',$search_area);
			  $query->select('roles.nombre as nombre_rol','areas.nombre as nombre_area','users.*');
		return $query;
	}

	public function scopeSearchPersonalByIdArea($query,$search_criteria){
		$query->withTrashed()
			  ->join('roles','roles.idrol','=','users.idrol')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('users.idarea','LIKE',"%$search_criteria%");
			  })
			  ->select('roles.nombre as nombre_rol','users.*');
		return $query;
	}

	public function scopeSearchPersonalActivoByIdArea($query,$search_criteria){
		$query->whereNested(function($query) use($search_criteria){
			  		$query->where('users.idarea','LIKE',"%$search_criteria%");
			  })
			  ->select(DB::raw('CONCAT(users.nombre," ",users.apellido_pat) as nombre_responsable'), 'id')
			  ->lists('nombre_responsable','id');
		return $query;
	}

	public function scopeSearchPersonalByNumeroDoc($query,$search_criteria){
		$query->withTrashed()
			  ->where('users.numero_doc_identidad','=',$search_criteria);			  	   
		return $query;
	}

	public function scopeGetJefes($query){
		$query->where('users.idrol','=',2)
			  ->orWhere('users.idrol','=',3);			  	   
		return $query;
	}

	public function scopeGetUserByTipoDocNumeroDoc($query,$tipo_documento,$numero_doc){
		$query->withTrashed()
			  ->where('users.idtipo_documento','=',$tipo_documento)
			  ->where('users.numero_doc_identidad','=',$numero_doc);			  	   
		return $query;
	}

	public function getUserFullNameAttribute()
	{
	    return $this->attributes['nombre'] .' '. $this->attributes['apellido_pat'] . ' ' . $this->attributes['apellido_mat'];
	}

	public function rol()
	{
		return $this->belongsTo('Rol', 'idrol','idrol');
	}

	public function area()
	{
		return $this->belongsTo('Area', 'idarea','idarea');
	}
	
}

<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Iper extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ipers';

	public function scopeGetIpersInfo($query,$tipo)
	{
		$query->withTrashed()
		 	  ->join('users','users.id','=','ipers.idusuario_elaborador');
		 	  if($tipo == 1)
		 	  	$query->join('servicios','servicios.idservicio','=','ipers.idservicio');
		 	  else
		 	  	$query->join('entorno_asistencial','entorno_asistencial.id','=','ipers.identorno_asistencial');
			  
			  $query->where('ipers.idtipo_iper','=',$tipo);

			  if($tipo == 1)
			  	$query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','servicios.nombre as nombre_servicio');
	  		  else
	  		  	$query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','entorno_asistencial.nombre as nombre_entorno');
	  	return $query;
	}

	public function scopeSearchIpersTS($query,$search_codigo,$search_anho,$search_usuario,$search_servicio,$tipo)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','ipers.idusuario_elaborador')
			  ->join('servicios','servicios.idservicio','=','ipers.idservicio');

			  if($search_codigo != '')
			  {
			  	$query->where(DB::raw("CONCAT(ipers.codigo_abreviatura,'-',ipers.codigo_tipo,'-',ipers.codigo_correlativo,'-',ipers.codigo_anho)"),'LIKE',"%$search_codigo%");
			  }	

			  if($search_servicio != '')
			  {
			  	$query->where("servicios.idservicio",'=',$search_servicio);
			  }		

			  if($search_usuario != '')
			  {
			  	$query->whereNested(function($query) use($search_usuario){
		  			$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  	});
			  }

			   if($search_anho != "")
				$query->where(DB::raw('STR_TO_DATE(ipers.fecha,\'%Y\')'),'>=',date('Y',strtotime($search_anho)));


			  $query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','servicios.nombre as nombre_servicio');

		return $query;
	}

	public function scopeSearchIpersSO($query,$search_codigo,$search_anho,$search_usuario,$search_entorno,$tipo)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','ipers.idusuario_elaborador')
			  ->join('entorno_asistencial','entorno_asistencial.id','=','ipers.identorno_asistencial');

			  if($search_codigo != '')
			  {
			  	$query->where(DB::raw("CONCAT(ipers.codigo_abreviatura,'-',ipers.codigo_tipo,'-',ipers.codigo_correlativo,'-',ipers.codigo_anho)"),'LIKE',"%$search_codigo%");
			  }	

			  if($search_entorno != '')
			  {
			  	$query->where("entorno_asistencial.id",'=',$search_entorno);
			  }		

			  if($search_usuario != '')
			  {
			  	$query->whereNested(function($query) use($search_usuario){
		  			$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  	});
			  }

			   if($search_anho != "")
				$query->where(DB::raw('STR_TO_DATE(ipers.fecha,\'%Y\')'),'>=',date('Y',strtotime($search_anho)));


			  $query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','entorno_asistencial.nombre as nombre_entorno');

		return $query;
	}

	public function scopeGetLastIper($query,$tipo)
	{
		$query->where('ipers.idtipo_iper','=',$tipo)
			->orderBy('id','desc');
	  	return $query;
	}

	public function scopeGetIperById($query,$id,$tipo){
		$query->withTrashed()
		 	  ->join('users','users.id','=','ipers.idusuario_elaborador');

		 	  if($tipo == 1)
		 	   	$query->join('servicios','servicios.idservicio','=','ipers.idservicio');
		 	  else
		 	  	$query->join('entorno_asistencial','entorno_asistencial.id','=','ipers.identorno_asistencial');
			  $query->where('ipers.id','=',$id)
			  ->where('ipers.idtipo_iper','=',$tipo);

			  if($tipo==1)
			    $query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','servicios.nombre as nombre_servicio');
	  		  else
	  		  	$query->select('ipers.*','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','entorno_asistencial.nombre as nombre_entorno');

	  	return $query;
	}

}
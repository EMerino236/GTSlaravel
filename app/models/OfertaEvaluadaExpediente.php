<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OfertaEvaluadaExpediente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'oferta_evaluada_expediente';
	protected $primaryKey = 'idoferta_evaluada_expediente';

	public function scopeGetOfertaEvaluadaExpedienteInfo($query)
	{
		$query->withTrashed()
			  ->rightjoin('oferta_expediente','oferta_expediente.idoferta_expediente','=','oferta_evaluada_expediente.idoferta_expediente')
			  ->join('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')			  
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->select('oferta_expediente.idoferta_expediente',
			  	'oferta_expediente.correlativo_por_expediente as correlativo_oferta_por_expediente',
			  	'servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  	'users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*',
			  	'oferta_evaluada_expediente.idoferta_evaluada_expediente')
			  ->orderBy('expediente_tecnico.codigo_compra')
			  ->orderBy('oferta_expediente.correlativo_por_expediente','asc');
	  	return $query;
	}

	public function scopeSearchOfertaEvaluadaExpediente($query,$search_codigo_compra,$search_usuario,$search_area,$search_servicio,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed()
			  ->rightjoin('oferta_expediente','oferta_expediente.idoferta_expediente','=','observacion_expediente.idoferta_expediente')
			  ->join('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')		  
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_servicio!='')
			  	$query->where('expediente_tecnico.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('expediente_tecnico.idarea','=',$search_area);
			  if($search_codigo_compra!="")
			  	$query->where('expediente_tecnico.codigo_compra','LIKE',"%$search_codigo_compra%");
			  if($search_fecha_ini != "")
				$query->where('expediente_tecnico.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('expediente_tecnico.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
		$query->select('oferta_expediente.idoferta_expediente',
			  	'oferta_expediente.correlativo_por_expediente as correlativo_oferta_por_expediente',
			  	'servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  	'users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*','oferta_evaluada_expediente.*')
			  ->orderBy('expediente_tecnico.codigo_compra')
			  ->orderBy('oferta_expediente.correlativo_por_expediente','asc');
	  	return $query;
	}

	public function scopeGetOfertaEvaluadaExpedientePorUsuario($query,$oferta_expediente,$user)
	{
		$query->withTrashed()
			  ->rightjoin('oferta_expediente','oferta_expediente.idoferta_expediente','=','oferta_evaluada_expediente.idoferta_expediente')
			  ->join('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')
			  ->where('oferta_evaluada_expediente.idoferta_expediente','=',$oferta_expediente)
			  ->where('oferta_evaluada_expediente.iduser','=',$user)
			  ->select('oferta_evaluada_expediente.*','expediente_tecnico.estado_evaluacion_ofertas_finalizada',
			  			'expediente_tecnico.idpresidente');
	  	return $query;
	}
}
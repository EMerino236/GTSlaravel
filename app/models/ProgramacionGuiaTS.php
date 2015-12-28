<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionGuiaTS extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'programacion_guia_ts';
	protected $primaryKey = 'id';

	
	function scopeGetTodosUsuarios($query,$anho)
	{
		$usuarios_cn = DB::table('programacion_guia_ts')->distinct()->join('users','users.id','=','programacion_guia_ts.iduser')
						->whereYear('programacion_guia_ts.fecha','=',$anho)
						->select('programacion_guia_ts.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_etes = DB::table('programacion_reporte_etes')->distinct()->join('users','users.id','=','programacion_reporte_etes.iduser')
						->whereYear('programacion_reporte_etes.fecha','=',$anho)
						->select('programacion_reporte_etes.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_paac = DB::table('programacion_reporte_paac')->distinct()->join('users','users.id','=','programacion_reporte_paac.iduser')
						->whereYear('programacion_reporte_paac.fecha','=',$anho)
						->select('programacion_reporte_paac.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$query = $usuarios_cn
				->union($usuarios_etes)
				->union($usuarios_paac)
				->distinct('iduser');
		return $query;
	}

	
	function scopeSearchTodosUsuarios($query,$anho,$search_usuario)
	{
		$usuarios_cn = DB::table('programacion_guia_ts')->distinct()->join('users','users.id','=','programacion_guia_ts.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_guia_ts.fecha','=',$anho)
						->select('programacion_guia_ts.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_etes = DB::table('programacion_reporte_etes')->distinct()->join('users','users.id','=','programacion_reporte_etes.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_reporte_etes.fecha','=',$anho)
						->select('programacion_reporte_etes.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$usuarios_paac = DB::table('programacion_reporte_paac')->distinct()->join('users','users.id','=','programacion_reporte_paac.iduser')
						->whereNested(function($query) use($search_usuario){
						  		$query->where('users.nombre','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
						  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
						  })
						->whereYear('programacion_reporte_paac.fecha','=',$anho)
						->select('programacion_reporte_paac.iduser','users.apellido_pat','users.apellido_mat','users.nombre');
		$query = $usuarios_cn
				->union($usuarios_etes)
				->union($usuarios_paac)
				->distinct('iduser');
		return $query;
	}
	

	function scopeGetProgramacionesReporteTS($query,$anho)
	{	
		$query = $query->where(DB::raw('YEAR(fecha)'),'=',$anho);
		return $query;
	}

	public function usuario()
	{
		return $this->belongsTo('User','iduser');
	}

	public function tipo()
	{
		return $this->belongsTo('SubtipoDocumentoInf','id_tipo');
	}

	public function guia()
	{
		return $this->belongsTo('DocumentoInf','id_guia','iddocumentosinf');
	}

}
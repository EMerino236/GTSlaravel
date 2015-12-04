<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentoPlanDirector extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentosPlanDirector';
	protected $table = 'documentosplandirector';

	public function scopeGetDocumentosPlanDirectorInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentosplandirector','tipo_documentosplandirector.idtipo_documentosPlanDirector','=','documentosplandirector.idtipo_documentosPlanDirector')
			  ->select('tipo_documentosplandirector.nombre as tipo_documento','documentosplandirector.*');
	  	return $query;
	}

	public function scopeSearchDocumentosPlanDirector($query,$search_fecha_ini,$search_fecha_fin,$search_tipo_documento_plan_director)
	{
		$query->withTrashed()
			  ->join('tipo_documentosplandirector','tipo_documentosplandirector.idtipo_documentosPlanDirector','=','documentosplandirector.idtipo_documentosPlanDirector');
			  if($search_fecha_ini != "")
				$query->where('documentosplandirector.anho','>=',$search_fecha_ini);
			  if($search_fecha_fin != "")
				$query->where('documentosplandirector.anho','<=',$search_fecha_fin);
			  if($search_tipo_documento_plan_director!='')
			  	$query->where('documentosplandirector.idtipo_documentosPlanDirector','=',$search_tipo_documento_plan_director);
			  $query->select('tipo_documentosplandirector.nombre as tipo_documento','documentosplandirector.*');
	  	return $query;
	}

}
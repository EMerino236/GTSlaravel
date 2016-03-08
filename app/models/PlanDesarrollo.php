<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanDesarrollo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'planes_desarrollo_rrhh';

	public function scopeSearchPlanDesarrollo($query,$search_codigo_documento,$search_nombre_documento,$search_autor_documento)
	{
		
		if($search_codigo_documento != "")
		{
			$query->where('planes_desarrollo_rrhh.codigo_archivamiento','=',$search_codigo_documento);
		}

		if($search_nombre_documento != "")
		{
			$query->where('planes_desarrollo_rrhh.nombre','LIKE',"%$search_nombre_documento%");
		}

		if($search_autor_documento != "")
		{
			$query->where('planes_desarrollo_rrhh.autor','LIKE', "%$search_autor_documento%");
		}

		$query->select('planes_desarrollo_rrhh.*');		
		
		return $query;
	}
	
}
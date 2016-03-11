<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanDifusion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'planes_difusion';
	
	public function departamento()
	{
		return $this->belongsTo('Area', 'iddepartamento','idarea');
	}

	public function servicio()
	{
		return $this->belongsTo('Servicio', 'idservicio');
	}

	public function responsable()
	{
		return $this->belongsTo('User','idresponsable', 'id');
	}

	public function scopeSearchPlanDifusion($query,$search_nombre_plan_difusion, $search_departamento_plan_difusion, $search_servicio_plan_difusion,
					 						$search_responsable_plan_difusion, $fecha_ini_plan_difusion, $fecha_fin_plan_difusion)
	{
		
		if($search_nombre_plan_difusion != "")
		{
			$query->where('planes_difusion.nombre','LIKE',"%$search_nombre_plan_difusion%");
		}

		if($search_departamento_plan_difusion != "")
		{
			$query->where('planes_difusion.iddepartamento','=',$search_departamento_plan_difusion);
		}

		if($search_servicio_plan_difusion != "")
		{
			$query->where('planes_difusion.idservicio','=', $search_servicio_plan_difusion);
		}

		if($search_responsable_plan_difusion != "")
		{

		}

		if($fecha_ini_plan_difusion != "")
		{
			$query->where(DB::raw('STR_TO_DATE(planes_difusion.fechainicio,\'%Y-%m-%d\')'),'=',date('Y-m-d H:i:s',strtotime($fecha_ini_plan_difusion)));			  	
		}

		if($fecha_fin_plan_difusion != "")
		{
			$query->where(DB::raw('STR_TO_DATE(planes_difusion.fechafin,\'%Y-%m-%d\')'),'=',date('Y-m-d H:i:s',strtotime($fecha_fin_plan_difusion)));			  	
		}

		$query->select('planes_difusion.*');		
		
		return $query;
	}
}
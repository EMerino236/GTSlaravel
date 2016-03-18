<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AcuerdoConvenio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'acuerdos_convenios';

	public function scopeSearchAcuerdoConvenio($query,$search_nombre_convenio,$search_duracion_convenio,$fecha_ini_firma_convenio,$fecha_fin_firma_convenio)
	{
		
		if($search_nombre_convenio != "")
		{
			$query->where('acuerdos_convenios.nombre','LIKE',"%$search_nombre_convenio%");
		}

		if($search_duracion_convenio != "")
		{
			$query->where('acuerdos_convenios.duracion','=',$search_duracion_convenio);
		}		

		if($fecha_ini_firma_convenio != "")
		{
			$query->where(DB::raw('STR_TO_DATE(acuerdos_convenios.fechafirma,\'%Y-%m-%d\')'),'>=',date('Y-m-d H:i:s',strtotime($fecha_ini_firma_convenio)));			  	
		}

		if($fecha_fin_firma_convenio != "")
		{
			$query->where(DB::raw('STR_TO_DATE(acuerdos_convenios.fechafirma,\'%Y-%m-%d\')'),'<=',date('Y-m-d H:i:s',strtotime($fecha_fin_firma_convenio)));			  	
		}

		$query->select('acuerdos_convenios.*');		
		
		return $query;
	}

}
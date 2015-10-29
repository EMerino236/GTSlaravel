<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajosxactivo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idorden_trabajoxactivo';

	public function scopeGetOtXActivoXPeriodo($query,$tipo,$idestado,$fecha_ini,$fecha_fin)
	{
		$query->join('ordenes_trabajos','ordenes_trabajos.idordenes_trabajo','=','ordenes_trabajosxactivos.idordenes_trabajo')
			  ->where('ordenes_trabajos.idtipo_ordenes_trabajo','=',$tipo)
			  ->where('ordenes_trabajos.idestado','=',$idestado)
			  ->where('ordenes_trabajos.fecha_programacion','>=',$fecha_ini)
			  ->where('ordenes_trabajos.fecha_programacion','<=',$fecha_fin)
			  ->select('ordenes_trabajos.fecha_programacion','ordenes_trabajos.idordenes_trabajo');
		return $query;
	}

	public function scopeGetOtXActivo($query,$idordenes_trabajo,$idactivo)
	{
		$query->where('ordenes_trabajosxactivos.idordenes_trabajo','=',$idordenes_trabajo)
			  ->where('ordenes_trabajosxactivos.idactivo','=',$idactivo);
		return $query;
	}

	

}
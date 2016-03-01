<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProgramacionCompraAdquisicion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'programacion_compra_adquisicion';
	protected $primaryKey = 'idprogramacion_compra';

	public function scopeGetProgramacionCompraInfo($query,$anho)
	{
		$query->join('tipo_compra','programacion_compra_adquisicion.idtipo_compra','=','tipo_compra.idtipo_compra')
			  ->join('unidad_medida','programacion_compra_adquisicion.idunidad_medida','=','unidad_medida.idunidad_medida')
			  ->join('areas','programacion_compra_adquisicion.idarea','=','areas.idarea')
			  ->join('servicios','programacion_compra_adquisicion.idservicio','=','servicios.idservicio')
			  ->join('users as usuario','programacion_compra_adquisicion.iduser','=','usuario.id')
			  ->join('users as responsable','programacion_compra_adquisicion.iduser','=','responsable.id')
			  ->whereYear('programacion_compra_adquisicion.fecha_aproximada_adquisicion','=',$anho)
			  ->select('tipo_compra.nombre as tipo_compra','unidad_medida.nombre as unidad_medida','areas.nombre as nombre_area','usuario.nombre as nombre_usuario','usuario.apellido_pat as apellido_pat_usuario','usuario.apellido_mat as apellido_mat_usuario','responsable.nombre as nombre_responsable','responsable.apellido_pat as apellido_pat_responsable','responsable.apellido_mat as apellido_mat_responsable','servicios.nombre as nombre_servicio','programacion_compra_adquisicion.*');
	  	return $query;
	}
}
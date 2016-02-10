<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteDesarrolloIndicador extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reportes_desarrollo_indicadores';

	public function dimension()
	{
		return $this->belongsTo('Dimension', 'dimension_id');
	}
}
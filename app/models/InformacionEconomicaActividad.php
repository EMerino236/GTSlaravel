<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InformacionEconomicaActividad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'informaciones_economicas_actividades';

}
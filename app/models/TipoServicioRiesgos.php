<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoServicioRiesgos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_servicio';

	
}
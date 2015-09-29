<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoServicio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_servicios';
}
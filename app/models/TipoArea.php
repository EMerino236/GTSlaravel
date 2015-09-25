<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoArea extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_areas';
}
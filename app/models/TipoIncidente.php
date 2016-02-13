<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoIncidente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_incidente';
}
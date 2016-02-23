<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoIper extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_iper';
}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RequerimientoClinicoEstado extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'requerimientos_clinicos_estados';
	protected $primaryKey = 'id';

}
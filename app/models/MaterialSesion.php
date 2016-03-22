<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialSesion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'materiales_sesion';	
	
}
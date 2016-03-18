<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Sesion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'sesiones';
	
}
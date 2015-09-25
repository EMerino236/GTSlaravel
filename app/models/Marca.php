<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Marca extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'marcas';

}
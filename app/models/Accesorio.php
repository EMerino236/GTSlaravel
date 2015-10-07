<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Accesorio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'accesorios';

}
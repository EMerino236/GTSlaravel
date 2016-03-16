<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Pais extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'paises';

}
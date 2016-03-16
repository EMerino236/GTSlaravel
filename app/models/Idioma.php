<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Idioma extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'idiomas';

}
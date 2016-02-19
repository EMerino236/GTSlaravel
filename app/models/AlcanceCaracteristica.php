<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceCaracteristica extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_caracteristicas';

}
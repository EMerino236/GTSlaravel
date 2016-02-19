<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceRequerimiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_requerimientos';

}
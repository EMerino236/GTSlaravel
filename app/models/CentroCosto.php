<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CentroCosto extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'centro_costos';

}
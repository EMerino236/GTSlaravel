<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RHTipo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'rh_tipos';
	
}
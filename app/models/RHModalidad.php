<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class RHModalidad extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'rh_modalidades';
	
}
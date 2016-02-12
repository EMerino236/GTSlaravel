<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GradoDanho extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'grado_danho';
}
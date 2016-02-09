<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Dimension extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'dimensiones';

}
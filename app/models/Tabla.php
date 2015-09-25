<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Tabla extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

}
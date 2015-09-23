<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Area extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

}
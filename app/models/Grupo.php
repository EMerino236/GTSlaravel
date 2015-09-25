<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Grupo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'grupos';

}
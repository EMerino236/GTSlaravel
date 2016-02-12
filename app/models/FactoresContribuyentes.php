<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class FactoresContribuyentes extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'factores_contribuyentes';

	

}
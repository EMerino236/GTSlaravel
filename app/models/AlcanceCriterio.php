<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceCriterio extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_criterios';

}
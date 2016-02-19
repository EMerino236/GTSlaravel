<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceRestriccion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_restricciones';

}
<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AlcanceAsuncion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'alcances_asunciones';

}
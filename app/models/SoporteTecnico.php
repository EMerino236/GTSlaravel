<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SoporteTecnico extends Eloquent {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;

	protected $table = 'soporte_tecnicos';
	protected $primaryKey = 'idsoporte_tecnico';
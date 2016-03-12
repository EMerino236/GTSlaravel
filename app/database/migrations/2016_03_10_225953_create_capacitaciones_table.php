<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('capacitaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('codigo')->nullable();
			$table->integer('id_tipo')->unsigned();
			$table->integer('id_modalidad')->unsigned();
			$table->text('descripcion');
			$table->string('codigo_patrimonial')->nullable();
			$table->string('equipo_relacionado')->nullable();
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->integer('id_servicio_clinico');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('capacitaciones');
	}

}

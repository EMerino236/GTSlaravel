<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacionesDocenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programaciones_docente', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_departamento');
			$table->integer('id_servicio_clinico');
			$table->integer('id_sesion')->unsigned();
			$table->integer('id_responsable')->unsigned();
			$table->integer('id_capacitacion')->unsigned();
			$table->date('fecha');
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
		Schema::drop('programaciones_docente');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proyectos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo');
			$table->string('nombre');
			$table->integer('id_categoria')->unsigned();
			$table->integer('id_servicio_clinico');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->text('proposito');
			$table->text('metodologia');
			$table->text('objetivos');
			$table->text('descripcion');
			$table->integer('id_requerimiento')->unsigned();
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
		Schema::drop('proyectos');
	}

}

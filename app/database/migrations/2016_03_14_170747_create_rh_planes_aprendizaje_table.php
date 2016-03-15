<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhPlanesAprendizajeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rh_planes_aprendizaje', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->integer('num_horas');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->text('descripcion');
			$table->text('personal');
			$table->text('objetivo');
			$table->text('competencias_requeridas');
			$table->string('infraestructura');
			$table->string('equipos');
			$table->string('herramientas');
			$table->string('insumos');
			$table->string('equipo_personal');
			$table->string('condiciones');
			$table->string('url')->nullable();
			$table->string('nombre_archivo')->nullable();
			$table->string('nombre_archivo_encriptado')->nullable();
			$table->integer('id_programacion')->unsigned();
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
		Schema::drop('rh_planes_aprendizaje');
	}

}

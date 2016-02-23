<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanesAprendizajeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planes_aprendizaje', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_categoria')->unsigned();
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
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
			$table->integer('id_proyecto')->unsigned();
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
		Schema::drop('planes_aprendizaje');
	}

}

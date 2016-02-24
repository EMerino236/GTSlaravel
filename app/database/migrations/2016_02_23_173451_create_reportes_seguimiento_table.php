<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesSeguimientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reportes_seguimiento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('codigo');
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->integer('id_proyecto')->unsigned();
			$table->string('url')->nullable();
			$table->string('nombre_archivo')->nullable();
			$table->string('nombre_archivo_encriptado')->nullable();
			$table->integer('id_cronograma')->unsigned()->nullable();
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
		Schema::drop('reportes_seguimiento');
	}

}

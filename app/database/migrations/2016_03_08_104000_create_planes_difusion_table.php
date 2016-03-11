<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanesDifusionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planes_difusion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',200);
			$table->string('descripcion',200);
			$table->integer('iddepartamento');
			$table->integer('idservicio');
			$table->integer('idresponsable');
			$table->date('fechainicio');
			$table->date('fechafin');
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
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
		Schema::drop('planes_difusion');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanesDesarrolloRrhhTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planes_desarrollo_rrhh', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',200);
			$table->string('descripcion',200);
			$table->string('codigo_archivamiento',100);
			$table->string('autor',200);
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
		Schema::drop('planes_desarrollo_rrhh');
	}

}

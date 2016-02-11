<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosServiciosClinicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentos_servicios_clinicos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_servicio');
			$table->string('codigo');
			$table->integer('id_usuario');
			$table->integer('id_estado');
			$table->string('nombre');
			$table->string('url')->nullable();
			$table->string('nombre_archivo')->nullable();
			$table->string('nombre_archivo_encriptado')->nullable();
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
		Schema::drop('documentos_servicios_clinicos');
	}

}

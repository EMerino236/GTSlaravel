<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombres');
			$table->string('apellido_paterno');
			$table->string('apellido_materno');
			$table->string('dni');
			$table->integer('id_pais_nacimiento')->unsigned();
			$table->integer('id_genero')->unsigned();
			$table->date('fecha_nacimiento');
			$table->integer('id_pais_residencia')->unsigned();
			$table->string('domicilio');
			$table->string('telefono');
			$table->string('celular');
			$table->string('email');
			$table->string('web');
			$table->string('institucion');
			$table->integer('id_rol')->unsigned();
			$table->integer('id_idioma_materno')->unsigned();
			$table->string('nombre_archivo')->nullable();
			$table->string('nombre_archivo_encriptado')->nullable();
			$table->string('url')->nullable();
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
		Schema::drop('perfiles');
	}

}

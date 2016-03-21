<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilesFormacionesAcademicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles_formaciones_academicas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_grado')->unsigned();
			$table->string('titulo');
			$table->string('centro');
			$table->integer('id_pais')->unsigned();
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->integer('id_perfil')->unsigned();
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
		Schema::drop('perfiles_formaciones_academicas');
	}

}

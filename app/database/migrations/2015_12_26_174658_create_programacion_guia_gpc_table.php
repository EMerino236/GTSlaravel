<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacionGuiaGpcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programacion_guia_gpc', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre_reporte', 100)->nullable();
			$table->date('fecha')->nullable();
			$table->integer('iduser');
			$table->integer('id_tipo')->unsigned();//subtipo
			$table->integer('id_estado');						
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
		Schema::drop('programacion_guia_gpc');
	}

}

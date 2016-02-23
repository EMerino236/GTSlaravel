<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanesAprendizajeRecursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planes_aprendizaje_recursos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('competencia_generada');
			$table->string('indicador');
			$table->integer('id_plan')->unsigned();
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
		Schema::drop('planes_aprendizaje_recursos');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosCronogramasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proyectos_cronogramas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
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
		Schema::drop('proyectos_cronogramas');
	}

}

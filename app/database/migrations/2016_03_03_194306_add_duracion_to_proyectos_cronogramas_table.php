<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDuracionToProyectosCronogramasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('proyectos_cronogramas', function(Blueprint $table)
		{
			$table->integer('duracion')->after('fecha_fin');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('proyectos_cronogramas', function(Blueprint $table)
		{
			//
		});
	}

}

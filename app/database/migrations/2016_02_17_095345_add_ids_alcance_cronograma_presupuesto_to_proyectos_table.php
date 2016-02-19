<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdsAlcanceCronogramaPresupuestoToProyectosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('proyectos', function(Blueprint $table)
		{
			$table->integer('id_cronograma')->unsigned()->nullable()->after('id_requerimiento');
			$table->integer('id_alcance')->unsigned()->nullable()->after('id_requerimiento');
			$table->integer('id_presupuesto')->unsigned()->nullable()->after('id_requerimiento');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('proyectos', function(Blueprint $table)
		{
			//
		});
	}

}

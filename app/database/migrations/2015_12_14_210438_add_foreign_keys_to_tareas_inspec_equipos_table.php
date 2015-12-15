<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTareasInspecEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_inspec_equipos', function(Blueprint $table)
		{
			$table->foreign('idfamilia_activo', 'fk_tareas_inspec_equipos_familia_activos1')->references('idfamilia_activo')->on('familia_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('creador', 'fk_tareas_inspec_equipos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_inspec_equipos', function(Blueprint $table)
		{
			$table->dropForeign('fk_tareas_inspec_equipos_familia_activos1');
			$table->dropForeign('fk_tareas_inspec_equipos_users1');
		});
	}

}

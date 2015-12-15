<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTareasOtBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_ot_busqueda_infos', function(Blueprint $table)
		{
			$table->foreign('idot_busqueda_info', 'fk_tareas_ot_busqueda_infos_ot_busqueda_infos1')->references('idot_busqueda_info')->on('ot_busqueda_infos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_realizado', 'fk_tareas_ot_busqueda_infos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_ot_busqueda_infos', function(Blueprint $table)
		{
			$table->dropForeign('fk_tareas_ot_busqueda_infos_ot_busqueda_infos1');
			$table->dropForeign('fk_tareas_ot_busqueda_infos_estados1');
		});
	}

}

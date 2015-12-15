<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTareasOtPreventivosxotPreventivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_ot_preventivosxot_preventivos', function(Blueprint $table)
		{
			$table->foreign('idtareas_ot_preventivo', 'fk_tareas_ot_preventivos_has_ot_preventivos_tareas_ot_prevent1')->references('idtareas_ot_preventivo')->on('tareas_ot_preventivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idot_preventivo', 'fk_tareas_ot_preventivos_has_ot_preventivos_ot_preventivos1')->references('idot_preventivo')->on('ot_preventivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_realizado', 'fk_tareas_ot_preventivosxot_preventivos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_ot_preventivosxot_preventivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_tareas_ot_preventivos_has_ot_preventivos_tareas_ot_prevent1');
			$table->dropForeign('fk_tareas_ot_preventivos_has_ot_preventivos_ot_preventivos1');
			$table->dropForeign('fk_tareas_ot_preventivosxot_preventivos_estados1');
		});
	}

}

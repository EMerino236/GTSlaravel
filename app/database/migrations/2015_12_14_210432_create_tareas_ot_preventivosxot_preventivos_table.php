<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasOtPreventivosxotPreventivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_ot_preventivosxot_preventivos', function(Blueprint $table)
		{
			$table->integer('idtareas_ot_preventivosxot_preventivo', true);
			$table->integer('idtareas_ot_preventivo')->index('fk_tareas_ot_preventivos_has_ot_preventivos_tareas_ot_preve_idx');
			$table->integer('idot_preventivo')->index('fk_tareas_ot_preventivos_has_ot_preventivos_ot_preventivos1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado_realizado')->index('fk_tareas_ot_preventivosxot_preventivos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_ot_preventivosxot_preventivos');
	}

}

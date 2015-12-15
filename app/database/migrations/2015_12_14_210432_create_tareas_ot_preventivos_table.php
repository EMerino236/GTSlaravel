<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasOtPreventivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_ot_preventivos', function(Blueprint $table)
		{
			$table->integer('idtareas_ot_preventivo', true);
			$table->string('nombre', 200);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idfamilia_activo')->nullable()->index('fk_tareas_ot_preventivos_familia_activos1_idx');
			$table->integer('creador')->index('fk_tareas_ot_preventivos_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_ot_preventivos');
	}

}

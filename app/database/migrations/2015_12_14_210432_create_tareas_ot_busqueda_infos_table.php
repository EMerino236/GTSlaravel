<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasOtBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_ot_busqueda_infos', function(Blueprint $table)
		{
			$table->integer('idtareas_ot_busqueda_info', true);
			$table->string('nombre', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idot_busqueda_info')->index('fk_tareas_ot_busqueda_infos_ot_busqueda_infos1_idx');
			$table->integer('idestado_realizado')->index('fk_tareas_ot_busqueda_infos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_ot_busqueda_infos');
	}

}

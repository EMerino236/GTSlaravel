<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToProgramacionGuiaGpcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_guia_gpc', function(Blueprint $table)
		{
			$table->foreign('id_estado')->references('idestado_programacion_reportes')->on('estado_programacion_reportes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_guia_gpc', function(Blueprint $table)
		{
			$table->dropForeign('programacion_guia_gpc_id_estado_foreign');
		});
	}

}

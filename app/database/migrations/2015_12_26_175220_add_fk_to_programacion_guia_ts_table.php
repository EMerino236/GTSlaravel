<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToProgramacionGuiaTsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_guia_ts', function(Blueprint $table)
		{
			$table->foreign('iduser')->references('id')->on('users');
			$table->foreign('id_tipo')->references('id')->on('subtipo_documentosinf');
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
		Schema::table('programacion_guia_ts', function(Blueprint $table)
		{
			$table->dropForeign('programacion_guia_ts_iduser_foreign');
			$table->dropForeign('programacion_guia_ts_id_tipo_foreign');
			$table->dropForeign('programacion_guia_ts_id_estado_foreign');
		});
	}

}

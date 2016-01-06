<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdGuiaToProgramacionGuiaGpcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_guia_gpc', function(Blueprint $table)
		{
			$table->foreign('id_guia')->references('iddocumentosinf')->on('documentosinf');
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
			$table->dropForeign('programacion_guia_gpc_id_guia_foreign');
		});
	}

}

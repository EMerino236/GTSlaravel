<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaPublicacionToProgramacionGuiaGpcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_guia_gpc', function(Blueprint $table)
		{
			$table->integer('fecha_publicacion')->nullable();
			DB::statement('ALTER TABLE programacion_guia_gpc DROP FOREIGN KEY programacion_guia_gpc_id_tipo_foreign;');
			DB::statement('ALTER TABLE programacion_guia_gpc MODIFY id_tipo INTEGER NULL;');
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
			//
		});
	}

}

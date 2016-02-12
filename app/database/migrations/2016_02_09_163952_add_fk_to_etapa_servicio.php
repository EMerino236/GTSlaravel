<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEtapaServicio extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('etapa_servicio', function(Blueprint $table)
		{
			$table->foreign('identornoxtipo')->references('id')->on('entorno_asistencialxtipo_servicio');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('etapa_servicio', function(Blueprint $table)
		{
			$table->dropForeign('etapa_servicio_identornoxtipo_foreign');
		});
	}

}

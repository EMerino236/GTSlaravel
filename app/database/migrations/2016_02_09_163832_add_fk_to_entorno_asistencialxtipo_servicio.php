<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEntornoAsistencialxtipoServicio extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entorno_asistencialxtipo_servicio', function(Blueprint $table)
		{
			$table->foreign('identorno')->references('id')->on('entorno_asistencial');
			$table->foreign('idtipo')->references('id')->on('tipo_servicio');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entorno_asistencialxtipo_servicio', function(Blueprint $table)
		{
			$table->dropForeign('entorno_asistencialxtipo_servicio_identorno_foreign');
			$table->dropForeign('entorno_asistencialxtipo_servicio_idtipo_foreign');
		});
	}

}

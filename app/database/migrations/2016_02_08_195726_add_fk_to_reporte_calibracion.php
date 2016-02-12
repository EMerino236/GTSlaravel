<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToReporteCalibracion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_calibracion', function(Blueprint $table)
		{
			$table->foreign('idactivo')->references('idactivo')->on('activos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_calibracion', function(Blueprint $table)
		{
			$table->dropForeign('reporte_calibracion_idactivo_foreign');
		});
	}

}

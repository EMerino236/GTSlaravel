<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoToReporteCalibracionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_calibracion', function(Blueprint $table)
		{
			$table->integer('idestado')->nullable();
			$table->foreign('idestado')->references('idestado')->on('estados');
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
			$table->dropForeign('reporte_calibracion_idestado_foreign');
		});
	}

}

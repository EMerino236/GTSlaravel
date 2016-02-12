<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToDetalleReporteCalibracion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_reporte_calibracion', function(Blueprint $table)
		{
			$table->foreign('idreporte_calibracion')->references('id')->on('reporte_calibracion');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_reporte_calibracion', function(Blueprint $table)
		{
			$table->dropForeign('detalle_reporte_calibracion_idreporte_calibracion_foreign');
		});
	}

}
